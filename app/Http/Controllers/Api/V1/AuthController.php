<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $login = trim($request->login);
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user  = User::with('branch')->where($field, $login)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->is_active) {
            return response()->json(['message' => 'Kredensial tidak valid.'], 401);
        }

        $token = $user->createToken('mobile')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user'  => $this->userResource($user),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'PARENT',
        ]);

        $token = $user->createToken('mobile')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $this->userResource($user)], 201);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $this->userResource($request->user()->load('branch'))]);
    }

    public function updateMe(Request $request)
    {
        $user = $request->user();
        $user->update($request->only(['name','email','province','city','district','village','address_line']));
        return response()->json(['user' => $this->userResource($user->fresh('branch'))]);
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate(['fcm_token' => 'required|string']);
        $request->user()->update(['fcm_token' => $request->fcm_token]);
        return response()->json(['message' => 'FCM token updated']);
    }

    private function userResource(User $user): array
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'phone'      => $user->phone,
            'email'      => $user->email,
            'role'       => $user->role,
            'photo_url'  => $user->photo_url,
            'branch_id'  => $user->branch_id,
            'branch'     => $user->branch ? ['id'=>$user->branch->id,'name'=>$user->branch->name] : null,
            'province'   => $user->province,
            'city'       => $user->city,
            'district'   => $user->district,
            'village'    => $user->village,
            'address_line' => $user->address_line,
        ];
    }
}
