<?php
namespace App\Http\Controllers\Web\Therapist;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Attendance;
use App\Models\Child;
use App\Models\Consultation;
use App\Models\Session;
use App\Models\ServiceRate;
use App\Models\TherapistFee;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    public function jadwal(Request $request) {
        $user = auth()->user();
        $date = $request->date ?? now('Asia/Jakarta')->toDateString();
        $bookings = Booking::with(['child','service','branch'])
            ->where('therapist_id', $user->id)
            ->whereDate('scheduled_date', $date)
            ->orderBy('scheduled_time')->get();
        return view('therapist.jadwal', compact('bookings','date'));
    }

    public function pasien() {
        $children = Child::whereHas('bookings', fn($q) =>
            $q->where('therapist_id', auth()->id())
        )->with('parent')->orderBy('name')->paginate(20);
        return view('therapist.pasien', compact('children'));
    }

    public function konsultasi() {
        $konsultasi = Consultation::with(['parent','child'])
            ->where(fn($q) => $q->where('therapist_id', auth()->id())->orWhere('status','OPEN'))
            ->orderByDesc('updated_at')->paginate(20);
        return view('therapist.konsultasi', compact('konsultasi'));
    }

    public function pendapatan(Request $request) {
        $user  = auth()->user();
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $bookings = Booking::with('service')
            ->where('therapist_id', $user->id)
            ->where('status','COMPLETED')
            ->whereYear('scheduled_date',$year)
            ->whereMonth('scheduled_date',$month)
            ->get();
        $serviceRates = ServiceRate::get()->keyBy('service_id');
        $total = 0;
        foreach ($bookings as $b) {
            $rate = $serviceRates[$b->service_id] ?? null;
            $fee  = TherapistFee::where('therapist_id',$user->therapist?->id)->where('service_id',$b->service_id)->first();
            if ($rate) {
                $total += $rate->fee_type === 'FLAT' ? $rate->fee_value : ($b->service->price * $rate->fee_value / 100);
            } elseif ($fee) {
                $total += $fee->fee_type === 'FLAT' ? $fee->fee_value : ($b->service->price * $fee->fee_value / 100);
            }
        }
        return view('therapist.pendapatan', compact('bookings','total','year','month'));
    }

    public function presensi() {
        $attendance = Attendance::firstOrNew(
            ['therapist_id'=>auth()->id(),'date'=>now('Asia/Jakarta')->toDateString()]
        );
        $homecareToday = Booking::with(['child','service'])
            ->where('therapist_id', auth()->id())
            ->where('is_homecare', true)
            ->whereDate('scheduled_date', now('Asia/Jakarta')->toDateString())
            ->get();
        return view('therapist.presensi', compact('attendance','homecareToday'));
    }

    public function togglePresensi(Request $request) {
        $att = Attendance::firstOrCreate(
            ['therapist_id'=>auth()->id(),'date'=>now('Asia/Jakarta')->toDateString()],
            ['branch_id'=>auth()->user()->branch_id]
        );
        if (!$att->clock_in) {
            $att->update(['clock_in'=>now(),'status'=>'PRESENT']);
        } elseif (!$att->clock_out) {
            $att->update(['clock_out'=>now()]);
        }
        return redirect()->back()->with('success','Presensi diperbarui.');
    }

    public function toggleHomecarePresensi(Request $request, $bookingId) {
        $booking = Booking::where('id',$bookingId)->where('therapist_id',auth()->id())->where('is_homecare',true)->firstOrFail();
        if (!$booking->homecare_arrived_at) {
            $booking->update(['homecare_arrived_at'=>now()]);
        } elseif (!$booking->homecare_finished_at) {
            $booking->update(['homecare_finished_at'=>now()]);
        }
        return redirect()->back()->with('success','Presensi homecare diperbarui.');
    }

    public function sesi($bookingId) {
        $booking = Booking::with(['child','service','session'])->findOrFail($bookingId);
        abort_if($booking->therapist_id !== auth()->id(), 403);
        return view('therapist.sesi', compact('booking'));
    }

    public function updateSesi(Request $request, $bookingId) {
        $booking = Booking::findOrFail($bookingId);
        abort_if($booking->therapist_id !== auth()->id(), 403);
        $data = $request->validate([
            'action'        => 'required|in:start,end',
            'notes'         => 'nullable|string',
            'weight_kg'     => 'nullable|numeric',
            'height_cm'     => 'nullable|numeric',
            'head_circ_cm'  => 'nullable|numeric',
        ]);
        if ($data['action'] === 'start') {
            $booking->update(['status'=>'IN_PROGRESS']);
            Session::updateOrCreate(['booking_id'=>$bookingId],[
                'id'        => 'ses-'.uniqid(),
                'started_at'=> now(),
                'therapist_id' => auth()->id(),
            ]);
        } else {
            $session = Session::where('booking_id',$bookingId)->firstOrFail();
            $session->update(['ended_at'=>now(),'notes'=>$data['notes']]);
            $booking->update(['status'=>'COMPLETED']);
            if ($data['weight_kg'] || $data['height_cm']) {
                \App\Models\GrowthMeasurement::create([
                    'id'          => 'gm-'.uniqid(),
                    'child_id'    => $booking->child_id,
                    'booking_id'  => $bookingId,
                    'measured_at' => now(),
                    'weight_kg'   => $data['weight_kg'],
                    'height_cm'   => $data['height_cm'],
                    'head_circ_cm'=> $data['head_circ_cm'],
                ]);
            }
        }
        return redirect()->back()->with('success','Sesi diperbarui.');
    }
}
