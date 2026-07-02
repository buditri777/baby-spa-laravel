<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request) {
        $q = User::with("branch");
        if ($request->search) $q->where(fn($s)=>$s->where("name","like","%{$request->search}%")->orWhere("phone","like","%{$request->search}%"));
        if ($request->role)   $q->where("role",$request->role);
        $users    = $q->orderBy("name")->paginate(20)->withQueryString();
        $branches = Branch::where("is_active",true)->get();
        return view("owner.users", compact("users","branches"));
    }
    public function edit($id) {
        $user     = User::with("branch")->findOrFail($id);
        $branches = Branch::where("is_active",true)->get();
        return view("owner.users-form", compact("user","branches"));
    }
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->only(["name","email","role","branch_id","is_active","province","city","district","village"]);
        if ($request->filled("password")) $data["password"] = Hash::make($request->password);
        $user->update($data);
        return redirect()->route("owner.users.index")->with("success","User diperbarui.");
    }
    public function destroy($id) {
        User::findOrFail($id)->update(["is_active"=>false]);
        return redirect()->route("owner.users.index")->with("success","User dinonaktifkan.");
    }
    public function create() { return redirect()->route("owner.staf.create"); }
    public function store(Request $request) { return redirect()->route("owner.users.index"); }
    public function show($id) { return $this->edit($id); }
}
