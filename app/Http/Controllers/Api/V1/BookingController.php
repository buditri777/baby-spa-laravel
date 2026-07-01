<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $q = Booking::with(['child','service','therapist','branch'])
            ->orderByDesc('scheduled_at');

        if ($user->role === 'PARENT') {
            $q->whereHas('child', fn($c) => $c->where('parent_id', $user->id));
        } elseif ($user->role === 'THERAPIST') {
            $q->where('therapist_id', $user->id);
        } elseif ($scope = $user->branchScope()) {
            $q->where('branch_id', $scope);
        }

        return response()->json($q->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'child_id'     => 'required|string|exists:children,id',
            'therapist_id' => 'required|string|exists:users,id',
            'service_id'   => 'required|string|exists:services,id',
            'branch_id'    => 'nullable|string|exists:branches,id',
            'scheduled_at' => 'required|date',
            'is_homecare'  => 'boolean',
            'notes'        => 'nullable|string',
        ]);

        $service = Service::findOrFail($data['service_id']);
        $data['total_price'] = $service->price;
        $data['duration_min'] = $service->duration_min;

        $booking = Booking::create($data);
        return response()->json($booking->load(['child','service','therapist']), 201);
    }

    public function walkIn(Request $request)
    {
        $data = $request->validate([
            'child_id'     => 'required|string|exists:children,id',
            'therapist_id' => 'required|string|exists:users,id',
            'service_id'   => 'required|string|exists:services,id',
            'branch_id'    => 'nullable|string',
            'scheduled_at' => 'required|date',
        ]);
        $service = Service::findOrFail($data['service_id']);
        $data['total_price'] = $service->price;
        $data['duration_min'] = $service->duration_min;
        $data['is_walk_in'] = true;
        $data['status'] = 'CONFIRMED';
        $booking = Booking::create($data);
        return response()->json($booking->load(['child','service','therapist']), 201);
    }

    public function homecarePresence(Request $request, string $bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('therapist_id', $request->user()->id)
            ->where('is_homecare', true)
            ->firstOrFail();

        if (!$booking->homecare_arrived_at) {
            $booking->update(['homecare_arrived_at' => now()]);
            return response()->json(['status' => 'arrived', 'booking' => $booking->fresh()]);
        }
        $booking->update(['homecare_finished_at' => now()]);
        return response()->json(['status' => 'finished', 'booking' => $booking->fresh()]);
    }
}
