<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Services\FcmService;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function __construct(private FcmService $fcm) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $q = Consultation::with(['parent','therapist','child'])->orderByDesc('updated_at');

        if ($user->role === 'PARENT') {
            $q->where('parent_id', $user->id);
        } elseif ($user->role === 'THERAPIST') {
            $q->where(fn($q2) => $q2->where('therapist_id', $user->id)->orWhere('status','OPEN'));
        } elseif ($scope = $user->branchScope()) {
            $q->where('branch_id', $scope);
        }

        return response()->json($q->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'child_id' => 'nullable|string|exists:children,id',
            'topic'    => 'nullable|string|max:255',
        ]);
        $data['parent_id'] = $request->user()->id;
        $data['status']    = 'OPEN';
        $data['last_activity_at'] = now();
        $consultation = Consultation::create($data);
        return response()->json($consultation->load('parent','child'), 201);
    }

    public function messages(Request $request, string $id)
    {
        $consultation = Consultation::findOrFail($id);
        $messages = $consultation->messages()->with('sender')->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request, string $id)
    {
        $request->validate(['body' => 'required|string']);
        $consultation = Consultation::findOrFail($id);
        $msg = ConsultationMessage::create([
            'consultation_id' => $id,
            'sender_id'       => $request->user()->id,
            'body'            => $request->body,
            'type'            => 'TEXT',
        ]);
        $consultation->update(['last_activity_at' => now()]);
        return response()->json($msg->load('sender'), 201);
    }

    public function claim(Request $request, string $id)
    {
        $consultation = Consultation::where('id', $id)->where('status','OPEN')->firstOrFail();
        $consultation->update([
            'therapist_id' => $request->user()->id,
            'status'       => 'CLAIMED',
            'claimed_at'   => now(),
        ]);
        return response()->json($consultation->fresh());
    }

    public function close(Request $request, string $id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->update(['status' => 'CLOSED', 'closed_at' => now()]);
        return response()->json($consultation->fresh());
    }

    public function markRead(Request $request, string $id)
    {
        ConsultationMessage::where('consultation_id', $id)
            ->whereNull('read_at')
            ->where('sender_id', '!=', $request->user()->id)
            ->update(['read_at' => now()]);
        return response()->json(['ok' => true]);
    }
}
