<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index() {
        $branches = Branch::withCount(['bookings','therapists'])->orderBy('name')->paginate(20);
        return view('owner.cabang', compact('branches'));
    }
    public function create() { return view('owner.cabang-form'); }
    public function store(Request $request) {
        $data = $request->validate(['name'=>'required|string|max:255','address'=>'nullable|string','phone'=>'nullable|string','is_active'=>'boolean']);
        $data['id'] = 'br-'.uniqid();
        $data['is_active'] = $request->boolean('is_active',true);
        Branch::create($data);
        return redirect()->route('owner.cabang.index')->with('success','Cabang ditambahkan.');
    }
    public function edit($id) {
        $branch = Branch::findOrFail($id);
        return view('owner.cabang-form', compact('branch'));
    }
    public function update(Request $request, $id) {
        Branch::findOrFail($id)->update($request->only(['name','address','phone','is_active']));
        return redirect()->route('owner.cabang.index')->with('success','Cabang diperbarui.');
    }
    public function destroy($id) {
        Branch::findOrFail($id)->update(['is_active'=>false]);
        return redirect()->route('owner.cabang.index')->with('success','Cabang dinonaktifkan.');
    }
}
