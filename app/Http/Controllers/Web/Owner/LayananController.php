<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Branch;
use App\Models\ServiceRate;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index() {
        $services = Service::with(['branch','rate'])->orderBy('name')->paginate(20);
        return view('owner.layanan', compact('services'));
    }
    public function create() {
        $branches = Branch::where('is_active',true)->get();
        return view('owner.layanan-form', compact('branches'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|string',
            'duration_min'   => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'age_min_months' => 'nullable|integer',
            'age_max_months' => 'nullable|integer',
            'branch_id'      => 'nullable|string',
            'is_active'      => 'boolean',
        ]);
        $data['id']   = 'svc-'.uniqid();
        $data['slug'] = str($data['name'])->slug();
        $data['is_active'] = $request->boolean('is_active', true);
        Service::create($data);
        return redirect()->route('owner.layanan.index')->with('success','Layanan ditambahkan.');
    }
    public function edit($id) {
        $service  = Service::with('rate')->findOrFail($id);
        $branches = Branch::where('is_active',true)->get();
        return view('owner.layanan-form', compact('service','branches'));
    }
    public function update(Request $request, $id) {
        $service = Service::findOrFail($id);
        $service->update($request->only(['name','category','duration_min','price','description','age_min_months','age_max_months','branch_id','is_active']));
        // upsert rate
        if ($request->has('fee_type')) {
            ServiceRate::updateOrCreate(['service_id'=>$id],[
                'id'                 => 'sr-'.uniqid(),
                'fee_type'           => $request->fee_type,
                'fee_value'          => $request->fee_value ?? 0,
                'homecare_base_fee'  => $request->homecare_base_fee ?? 0,
                'homecare_per_km_fee'=> $request->homecare_per_km_fee ?? 0,
            ]);
        }
        return redirect()->route('owner.layanan.index')->with('success','Layanan diperbarui.');
    }
    public function destroy($id) {
        Service::findOrFail($id)->update(['is_active'=>false]);
        return redirect()->route('owner.layanan.index')->with('success','Layanan dinonaktifkan.');
    }
}
