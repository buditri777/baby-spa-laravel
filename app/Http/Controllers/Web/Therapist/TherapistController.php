<?php
namespace App\Http\Controllers\Web\Therapist;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Attendance;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    public function jadwal()
    {
        $user = auth()->user();
        $bookings = Booking::with(['child','service'])
            ->where('therapist_id', $user->id)
            ->whereDate('scheduled_at', now()->toDateString())
            ->orderBy('scheduled_at')->get();
        return view('therapist.jadwal', compact('bookings'));
    }
    public function pasien()
    {
        $children = \App\Models\Child::whereHas('bookings', fn($q) =>
            $q->where('therapist_id', auth()->id())
        )->with('parent')->orderBy('name')->get();
        return view('therapist.pasien', compact('children'));
    }
    public function konsultasi()
    {
        $konsultasi = \App\Models\Consultation::with(['parent','child'])
            ->where(fn($q) => $q->where('therapist_id', auth()->id())->orWhere('status','OPEN'))
            ->orderByDesc('updated_at')->paginate(20);
        return view('therapist.konsultasi', compact('konsultasi'));
    }
    public function pendapatan()
    {
        $sessions = Booking::with('service')
            ->where('therapist_id', auth()->id())
            ->where('status','COMPLETED')
            ->whereMonth('scheduled_at', now()->month)
            ->get();
        return view('therapist.pendapatan', compact('sessions'));
    }
    public function presensi()
    {
        $attendance = Attendance::firstOrNew(
            ['therapist_id'=>auth()->id(),'date'=>now('Asia/Jakarta')->toDateString()]
        );
        $homecareToday = Booking::with('child','service')
            ->where('therapist_id', auth()->id())
            ->where('is_homecare', true)
            ->whereDate('scheduled_at', now('Asia/Jakarta')->toDateString())
            ->get();
        return view('therapist.presensi', compact('attendance','homecareToday'));
    }
    public function togglePresensi(Request $request)
    {
        $att = Attendance::firstOrCreate(
            ['therapist_id'=>auth()->id(),'date'=>now('Asia/Jakarta')->toDateString()],
            ['branch_id'=>auth()->user()->branch_id]
        );
        if (!$att->clock_in) $att->update(['clock_in'=>now(),'status'=>'PRESENT']);
        else $att->update(['clock_out'=>now()]);
        return back()->with('success','Presensi berhasil.');
    }
    public function sesi($bookingId)
    {
        $booking = Booking::with(['child','service','session'])->findOrFail($bookingId);
        return view('therapist.sesi', compact('booking'));
    }
    public function updateSesi(Request $request, $bookingId) { return back()->with('success','Sesi diperbarui.'); }
}
