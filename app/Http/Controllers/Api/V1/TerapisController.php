<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TerapisController extends Controller
{
    public function jadwal(Request $request)
    {
        $user = $request->user();
        $date = $request->get('date', now()->toDateString());
        $bookings = Booking::with(['child','service','branch'])
            ->where('therapist_id', $user->id)
            ->whereDate('scheduled_at', $date)
            ->orderBy('scheduled_at')
            ->get();
        return response()->json($bookings);
    }

    public function pasien(Request $request)
    {
        $user = $request->user();
        $children = \App\Models\Child::whereHas('bookings', fn($q) =>
            $q->where('therapist_id', $user->id)
        )->with('parent')->orderBy('name')->get();
        return response()->json($children);
    }

    public function pendapatan(Request $request)
    {
        $user  = $request->user();
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $sessions = Booking::with('service')
            ->where('therapist_id', $user->id)
            ->where('status', 'COMPLETED')
            ->whereYear('scheduled_at', $year)
            ->whereMonth('scheduled_at', $month)
            ->get();

        $total = $sessions->sum(fn($b) => $b->service->price ?? 0);
        return response()->json(['sessions' => $sessions, 'total' => $total]);
    }

    public function presensi(Request $request)
    {
        $user = $request->user();
        $date = now('Asia/Jakarta')->toDateString();
        $attendance = Attendance::firstOrCreate(
            ['therapist_id' => $user->id, 'date' => $date],
            ['branch_id' => $user->branch_id]
        );

        if (!$attendance->clock_in) {
            $attendance->update(['clock_in' => now(), 'status' => 'PRESENT']);
            return response()->json(['action' => 'clock_in', 'attendance' => $attendance->fresh()]);
        }
        $attendance->update(['clock_out' => now()]);
        return response()->json(['action' => 'clock_out', 'attendance' => $attendance->fresh()]);
    }
}
