<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunPasienController extends Controller
{
    public function index(Request $request) {
        $q = User::where("role","PARENT")->with("children");
        if ($request->search) $q->where(fn($s)=>$s->where("name","like","%{$request->search}%")->orWhere("phone","like","%{$request->search}%"));
        $patients = $q->orderBy("name")->paginate(20)->withQueryString();
        return view("owner.akun-pasien", compact("patients"));
    }
    public function store(Request $request) {
        $data = $request->validate(["name"=>"required","phone"=>"required|unique:users,phone","password"=>"required|min:6"]);
        User::create([
            "id"               => "usr-".uniqid(),
            "name"             => $data["name"],
            "phone"            => $data["phone"],
            "password"         => Hash::make($data["password"]),
            "role"             => "PARENT",
            "is_active"        => true,
            "phone_verified_at"=> now(),
        ]);
        return redirect()->back()->with("success","Akun pasien dibuat.");
    }
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->only(["name","email","is_active"]);
        if ($request->filled("password")) $data["password"] = Hash::make($request->password);
        $user->update($data);
        return redirect()->back()->with("success","Akun diperbarui.");
    }
    public function destroy($id) {
        User::findOrFail($id)->update(["is_active"=>false]);
        return redirect()->back()->with("success","Akun dinonaktifkan.");
    }
}
