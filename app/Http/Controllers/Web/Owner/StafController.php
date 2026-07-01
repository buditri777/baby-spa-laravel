<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StafController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = User::whereIn('role',['THERAPIST','RECEPTIONIST','ADMIN','DIREKTUR'])->with('branch');
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) $q->where('branch_id',$user->branch_id);
        if ($request->search) $q->where(fn($s)=>$s->where('name','like',"%{$request->search}%")->orWhere('phone','like',"%{$request->search}%"));
        if ($request->role)   $q->where('role',$request->role);
        $staf = $q->orderBy('name')->paginate(20)->withQueryString();
        $branches = Branch::where('is_active',true)->get();
        return view('owner.staf', compact('staf','branches'));
    }
    public function create() {
        $branches = Branch::where('is_active',true)->get();
        return view('owner.staf-form', compact('branches'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|unique:users,phone',
            'email'     => 'nullable|email|unique:users,email',
            'role'      => 'required|in:THERAPIST,RECEPTIONIST,ADMIN,DIREKTUR',
            'branch_id' => 'nullable|string',
            'password'  => 'required|string|min:6',
        ]);
        $data['id']       = 'usr-'.uniqid();
        $data['password'] = Hash::make($data['password']);
        $data['is_active']= true;
        $data['phone_verified_at'] = now();
        $user = User::create($data);
        if ($data['role'] === 'THERAPIST') {
            Therapist::create([
                'id'        => 'th-'.uniqid(),
                'user_id'   => $user->id,
                'branch_id' => $data['branch_id'] ?? null,
                'is_active' => true,
            ]);
        }
        return redirect()->route('owner.staf.index')->with('success','Staf berhasil ditambahkan.');
    }
    public function edit($id) {
        $staf     = User::findOrFail($id);
        $branches = Branch::where('is_active',true)->get();
        return view('owner.staf-form', compact('staf','branches'));
    }
    public function update(Request $request, $id) {
        $staf = User::findOrFail($id);
        $data = $request->only(['name','email','branch_id','is_active']);
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);
        $staf->update($data);
        return redirect()->route('owner.staf.index')->with('success','Staf diperbarui.');
    }
    public function destroy($id) {
        User::findOrFail($id)->update(['is_active'=>false]);
        return redirect()->route('owner.staf.index')->with('success','Staf dinonaktifkan.');
    }
}
