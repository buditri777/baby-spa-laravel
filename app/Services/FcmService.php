<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    private string $projectId;
    private string $serviceAccountJson;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id', '');
        $this->serviceAccountJson = config('services.firebase.service_account_json', '');
    }

    public function sendToUser(string $userId, string $title, string $body, array $data = []): void
    {
        $user = User::find($userId);
        if (!$user || !$user->fcm_token) return;
        $this->send($user->fcm_token, $title, $body, $data);
    }

    public function sendToUsers(array $userIds, string $title, string $body, array $data = []): void
    {
        $tokens = User::whereIn('id', $userIds)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        foreach ($tokens as $token) $this->send($token, $title, $body, $data);
    }

    private function send(string $token, string $title, string $body, array $data = []): void
    {
        if (empty($this->projectId) || empty($this->serviceAccountJson)) return;
        try {
            $accessToken = $this->getAccessToken();
            Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", [
                    'message' => [
                        'token'        => $token,
                        'notification' => ['title' => $title, 'body' => $body],
                        'data'         => array_map('strval', $data),
                    ],
                ]);
        } catch (\Throwable $e) {
            Log::warning('FCM send failed: ' . $e->getMessage());
        }
    }

    private function getAccessToken(): string
    {
        // Simplified: use service account JSON to get access token
        $sa = json_decode($this->serviceAccountJson, true);
        if (!$sa) return '';
        $now = time();
        $payload = base64_encode(json_encode(['alg'=>'RS256','typ'=>'JWT'])) . '.' .
            base64_encode(json_encode([
                'iss'   => $sa['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'iat'   => $now,
                'exp'   => $now + 3600,
            ]));
        openssl_sign($payload, $sig, $sa['private_key'], 'SHA256');
        $jwt = $payload . '.' . base64_encode($sig);
        $res = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ]);
        return $res->json('access_token', '');
    }
}
