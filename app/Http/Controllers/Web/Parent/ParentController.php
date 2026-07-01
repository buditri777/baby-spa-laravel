<?php
namespace App\Http\Controllers\Web\Parent;
use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function anakIndex() {
        $children = Child::where('parent_id', auth()->id())->orderBy('name')->get();
        return view('parent.anak-index', compact('children'));
    }
    public function anakCreate() { return view('parent.anak-form'); }
    public function anakStore(Request $request) {
        $data = $request->validate(['name'=>'required','gender'=>'required|in:L,P','birth_date'=>'required|date','allergies'=>'nullable|string','notes'=>'nullable|string']);
        $data['id']        = 'ch-'.uniqid();
        $data['parent_id'] = auth()->id();
        Child::create($data);
        return redirect()->route('anak.index')->with('success','Data anak ditambahkan.');
    }
    public function anakShow($id) {
        $child = Child::with(['growthMeasurements','milestones','homeExercises','bookings.service'])
            ->where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        return view('parent.anak-show', compact('child'));
    }
    public function anakEdit($id) {
        $child = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        return view('parent.anak-form', compact('child'));
    }
    public function anakUpdate(Request $request, $id) {
        $child = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        $child->update($request->only(['name','gender','birth_date','allergies','medical_conditions','notes']));
        return redirect()->route('anak.show',$id)->with('success','Data anak diperbarui.');
    }
    public function tumbuhKembang($id) {
        $child      = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        $growth     = $child->growthMeasurements()->orderByDesc('measured_at')->get();
        $milestones = $child->milestones()->orderByDesc('achieved_at')->get();
        return view('parent.tumbuh-kembang', compact('child','growth','milestones'));
    }
    public function latihanRumah($id) {
        $child     = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        $exercises = $child->homeExercises()->orderByDesc('created_at')->get();
        return view('parent.latihan-rumah', compact('child','exercises'));
    }
    public function jadwal() {
        $bookings = Booking::with(['child','service','therapist','branch'])
            ->where('parent_id', auth()->id())
            ->orderByDesc('scheduled_date')->paginate(20);
        return view('parent.jadwal', compact('bookings'));
    }
    public function layanan() {
        $services = Service::where('is_active',true)->orderBy('name')->get();
        $children = Child::where('parent_id',auth()->id())->get();
        return view('parent.layanan', compact('services','children'));
    }
    public function bookingCreate(Request $request) {
        $children   = Child::where('parent_id',auth()->id())->get();
        $services   = Service::where('is_active',true)->get();
        $therapists = User::where('role','THERAPIST')->where('is_active',true)->get();
        $childId    = $request->childId;
        $serviceId  = $request->serviceId;
        $service    = $serviceId ? Service::find($serviceId) : null;
        return view('parent.booking-form', compact('children','services','therapists','childId','serviceId','service'));
    }
    public function bookingStore(Request $request) {
        $data = $request->validate([
            'child_id'      => 'required|string',
            'service_id'    => 'required|string',
            'therapist_id'  => 'nullable|string',
            'scheduled_date'=> 'required|date|after_or_equal:today',
            'scheduled_time'=> 'required',
            'is_homecare'   => 'boolean',
            'notes'         => 'nullable|string',
        ]);
        $service = Service::findOrFail($data['service_id']);
        $data['id']          = 'bk-'.uniqid();
        $data['booking_code']= strtoupper(substr(uniqid(),0,8));
        $data['parent_id']   = auth()->id();
        $data['branch_id']   = $service->branch_id;
        $data['status']      = 'CONFIRMED';
        $data['is_homecare'] = $request->boolean('is_homecare');
        $booking = Booking::create($data);
        return redirect()->route('booking.sukses',$booking->id)->with('success','Booking berhasil dibuat.');
    }
    public function bookingSukses($id) {
        $booking = Booking::with(['child','service','therapist'])->findOrFail($id);
        return view('parent.booking-sukses', compact('booking'));
    }
    public function konsultasiIndex() {
        $konsultasi = Consultation::with(['child'])
            ->where('parent_id',auth()->id())
            ->orderByDesc('updated_at')->paginate(20);
        return view('parent.konsultasi-index', compact('konsultasi'));
    }
    public function konsultasiBaru() {
        $children = Child::where('parent_id',auth()->id())->get();
        return view('parent.konsultasi-index', compact('children'))->with('form',true);
    }
    public function konsultasiStore(Request $request) {
        $data = $request->validate(['child_id'=>'required|string','subject'=>'required|string|max:255','first_message'=>'required|string']);
        $konsul = Consultation::create([
            'id'        => 'cons-'.uniqid(),
            'parent_id' => auth()->id(),
            'child_id'  => $data['child_id'],
            'subject'   => $data['subject'],
            'status'    => 'OPEN',
        ]);
        ConsultationMessage::create([
            'id'              => 'cm-'.uniqid(),
            'consultation_id' => $konsul->id,
            'sender_id'       => auth()->id(),
            'message'         => $data['first_message'],
        ]);
        return redirect()->route('konsultasi.show',$konsul->id);
    }
    public function konsultasiShow($id) {
        $konsul   = Consultation::with(['child','messages.sender','therapist'])->where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        $children = Child::where('parent_id',auth()->id())->get();
        return view('parent.konsultasi-index', compact('konsul','children'));
    }
}
