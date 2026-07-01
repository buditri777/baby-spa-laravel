<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = Child::with(['parent','bookings']);
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) {
            $q->whereHas('bookings', fn($b) => $b->where('branch_id',$user->branch_id));
        }
        if ($request->search) $q->where(fn($s)=>$s->where('name','like',"%{$request->search}%")->orWhereHas('parent',fn($p)=>$p->where('name','like',"%{$request->search}%")));
        if ($request->province) $q->whereHas('parent', fn($p) => $p->where('province',$request->province));
        $children = $q->orderBy('name')->paginate(20)->withQueryString();
        return view('owner.pasien', compact('children'));
    }
    public function show($id) {
        $child = Child::with(['parent','bookings.service','growthMeasurements','milestones','homeExercises'])->findOrFail($id);
        return view('owner.pasien-form', compact('child'));
    }
    public function create() { return view('owner.pasien-form'); }
    public function store(Request $request) {
        return redirect()->route('owner.pasien.index')->with('success','Pasien ditambahkan.');
    }
    public function edit($id) {
        $child = Child::with('parent')->findOrFail($id);
        return view('owner.pasien-form', compact('child'));
    }
    public function update(Request $request, $id) {
        Child::findOrFail($id)->update($request->only(['name','gender','birth_date','allergies','medical_conditions','notes']));
        return redirect()->route('owner.pasien.index')->with('success','Data pasien diperbarui.');
    }
    public function destroy($id) {
        return redirect()->route('owner.pasien.index')->with('error','Hapus pasien tidak diizinkan.');
    }
}
