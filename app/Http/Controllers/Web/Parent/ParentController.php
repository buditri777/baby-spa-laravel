<?php
namespace App\Http\Controllers\Web\Parent;
use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function anakIndex() {
        $children = Child::where('parent_id', auth()->id())->orderBy('name')->get();
        return view('parent.anak-index', compact('children'));
    }
    public function anakCreate() { return view('parent.anak-form'); }
    public function anakStore(Request $request) {
        $data = $request->validate(['name'=>'required','gender'=>'required|in:L,P','birth_date'=>'required|date']);
        $data['parent_id'] = auth()->id();
        Child::create($data);
        return redirect()->route('anak.index')->with('success','Data anak ditambahkan.');
    }
    public function anakShow($id) {
        $child = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
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
        $child = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        $growth = $child->growthMeasurements()->orderByDesc('measured_at')->get();
        $milestones = $child->milestones()->get();
        return view('parent.tumbuh-kembang', compact('child','growth','milestones'));
    }
    public function latihanRumah($id) {
        $child = Child::where('id',$id)->where('parent_id',auth()->id())->firstOrFail();
        $exercises = $child->homeExercises()->orderByDesc('created_at')->get();
        return view('parent.latihan-rumah', compact('child','exercises'));
    }
    public function bookingCreate() {
        $children = Child::where('parent_id',auth()->id())->get();
        $services = Service::where('is_active',true)->get();
        $therapists = User::where('role','THERAPIST')->where('is_active',true)->get();
        return view('parent.booking-form', compact('children','services','therapists'));
    }
    public function bookingStore(Request $request) {
        $data = $request->validate(['child_id'=>'required','service_id'=>'required','therapist_id'=>'required','scheduled_at'=>'required|date']);
        $service = Service::findOrFail($data['service_id']);
        $data['total_price'] = $service->price;
        $data['duration_min'] = $service->duration_min;
        $booking = Booking::create($data);
        return redirect()->route('booking.sukses',$booking->id)->with('success','Booking berhasil dibuat.');
    }
    public function bookingSukses($id) {
        $booking = Booking::with(['child','service','therapist'])->findOrFail($id);
        return view('parent.booking-sukses', compact('booking'));
    }
    public function jadwal() {
        $bookings = Booking::with(['child','service','therapist'])
            ->whereHas('child', fn($q) => $q->where('parent_id',auth()->id()))
            ->orderByDesc('scheduled_at')->paginate(10);
        return view('parent.jadwal', compact('bookings'));
    }
    public function layanan() {
        $services = Service::where('is_active',true)->orderBy('category')->get();
        return view('parent.layanan', compact('services'));
    }
    public function konsultasiIndex() {
        $konsultasi = Consultation::with(['therapist','child'])
            ->where('parent_id',auth()->id())->orderByDesc('updated_at')->get();
        return view('parent.konsultasi-index', compact('konsultasi'));
    }
    public function konsultasiBaru() {
        $children = Child::where('parent_id',auth()->id())->get();
        return view('parent.konsultasi-form', compact('children'));
    }
    public function konsultasiStore(Request $request) {
        $data = $request->validate(['child_id'=>'nullable','topic'=>'nullable|string']);
        $data['parent_id'] = auth()->id();
        $data['status'] = 'OPEN';
        $data['last_activity_at'] = now();
        $k = Consultation::create($data);
        return redirect()->route('konsultasi.show',$k->id);
    }
    public function konsultasiShow($id) {
        $konsultasi = Consultation::with(['messages.sender','therapist','child'])->findOrFail($id);
        return view('parent.konsultasi-show', compact('konsultasi'));
    }
}
