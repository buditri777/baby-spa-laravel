<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Child;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = Booking::with(['child','service','therapist','branch','payment']);
        if (!in_array($user->role, ['OWNER','SUPER_ADMIN'])) {
            $q->where('branch_id', $user->branch_id);
        }
        if ($request->status) $q->where('status', $request->status);
        if ($request->date)   $q->whereDate('scheduled_date', $request->date);
        if ($request->search) $q->whereHas('child', fn($c) => $c->where('name','like',"%{$request->search}%"));
        $bookings = $q->orderByDesc('scheduled_date')->orderByDesc('scheduled_time')->paginate(20)->withQueryString();
        return view('owner.booking', compact('bookings'));
    }
    public function create() {
        $user = auth()->user();
        $branches  = Branch::where('is_active',true)->get();
        $services  = Service::where('is_active',true)->get();
        $therapists= User::where('role','THERAPIST')->where('is_active',true)->get();
        $children  = Child::with('parent')->orderBy('name')->get();
        return view('owner.booking-form', compact('branches','services','therapists','children'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'child_id'      => 'required|string',
            'service_id'    => 'required|string',
            'therapist_id'  => 'nullable|string',
            'branch_id'     => 'required|string',
            'scheduled_date'=> 'required|date',
            'scheduled_time'=> 'required',
            'is_homecare'   => 'boolean',
            'notes'         => 'nullable|string',
        ]);
        $service = Service::findOrFail($data['service_id']);
        $data['id']          = 'bk-'.uniqid();
        $data['booking_code']= strtoupper(substr(uniqid(),0,8));
        $data['status']      = 'CONFIRMED';
        $data['is_homecare'] = $request->boolean('is_homecare');
        Booking::create($data);
        return redirect()->route('owner.booking.index')->with('success','Booking berhasil dibuat.');
    }
    public function show($id) {
        $booking = Booking::with(['child','service','therapist','branch','payment','session'])->findOrFail($id);
        return view('owner.booking-form', compact('booking'));
    }
    public function edit($id) {
        $booking   = Booking::findOrFail($id);
        $branches  = Branch::where('is_active',true)->get();
        $services  = Service::where('is_active',true)->get();
        $therapists= User::where('role','THERAPIST')->where('is_active',true)->get();
        $children  = Child::with('parent')->orderBy('name')->get();
        return view('owner.booking-form', compact('booking','branches','services','therapists','children'));
    }
    public function update(Request $request, $id) {
        $booking = Booking::findOrFail($id);
        $booking->update($request->only(['status','notes','therapist_id','scheduled_date','scheduled_time','cancellation_reason']));
        if ($request->status === 'CANCELLED') $booking->update(['cancelled_at' => now()]);
        return redirect()->route('owner.booking.index')->with('success','Booking diperbarui.');
    }
    public function destroy($id) {
        Booking::findOrFail($id)->update(['status'=>'CANCELLED','cancelled_at'=>now()]);
        return redirect()->route('owner.booking.index')->with('success','Booking dibatalkan.');
    }
}
