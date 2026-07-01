<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Session;
use App\Models\GrowthMeasurement;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    public function show(Request $request, string $bookingId)
    {
        $booking = Booking::with(['child','service','session.media'])->findOrFail($bookingId);
        return response()->json($booking);
    }

    public function upsert(Request $request, string $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $data = $request->validate([
            'action'       => 'required|in:start,end',
            'notes'        => 'nullable|string',
            'weight_kg'    => 'nullable|numeric',
            'height_cm'    => 'nullable|numeric',
            'head_circ_cm' => 'nullable|numeric',
        ]);

        $session = Session::firstOrCreate(
            ['booking_id' => $bookingId],
            ['child_id' => $booking->child_id, 'therapist_id' => $request->user()->id]
        );

        if ($data['action'] === 'start') {
            $session->update(['started_at' => now(), 'status' => 'ONGOING']);
            $booking->update(['status' => 'CONFIRMED']);
        } else {
            $session->update([
                'ended_at'     => now(),
                'status'       => 'COMPLETED',
                'notes'        => $data['notes'] ?? $session->notes,
                'weight_kg'    => $data['weight_kg'] ?? $session->weight_kg,
                'height_cm'    => $data['height_cm'] ?? $session->height_cm,
                'head_circ_cm' => $data['head_circ_cm'] ?? $session->head_circ_cm,
            ]);
            $booking->update(['status' => 'COMPLETED']);

            if (!empty($data['weight_kg']) || !empty($data['height_cm'])) {
                GrowthMeasurement::create([
                    'child_id'   => $booking->child_id,
                    'session_id' => $session->id,
                    'measured_at'=> now()->toDateString(),
                    'weight_kg'  => $data['weight_kg'] ?? null,
                    'height_cm'  => $data['height_cm'] ?? null,
                    'head_circ_cm' => $data['head_circ_cm'] ?? null,
                ]);
            }
        }

        return response()->json($session->fresh());
    }

    public function storeMedia(Request $request, string $bookingId)
    {
        $request->validate(['url' => 'required|url', 'type' => 'in:IMAGE,VIDEO']);
        $session = Session::where('booking_id', $bookingId)->firstOrFail();
        $media = $session->media()->create([
            'url'  => $request->url,
            'type' => $request->type ?? 'IMAGE',
        ]);
        return response()->json($media, 201);
    }
}
