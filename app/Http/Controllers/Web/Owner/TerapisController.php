<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Therapist;
use App\Models\Branch;
use App\Models\TherapistFee;
use App\Models\Service;
use Illuminate\Http\Request;

class TerapisController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = Therapist::with(["user","branch"]);
        if (!in_array($user->role,["OWNER","SUPER_ADMIN"])) $q->where("branch_id",$user->branch_id);
        if ($request->search) $q->whereHas("user",fn($u)=>$u->where("name","like","%{$request->search}%"));
        $therapists = $q->orderBy("id")->paginate(20)->withQueryString();
        $branches   = Branch::where("is_active",true)->get();
        return view("owner.terapis", compact("therapists","branches"));
    }
    public function edit($id) {
        $therapist = Therapist::with(["user","branch","fees.service"])->findOrFail($id);
        $branches  = Branch::where("is_active",true)->get();
        $services  = Service::where("is_active",true)->get();
        return view("owner.terapis-form", compact("therapist","branches","services"));
    }
    public function update(Request $request, $id) {
        $therapist = Therapist::findOrFail($id);
        $therapist->update($request->only(["branch_id","specialization","bio","years_experience","base_salary","is_active"]));
        return redirect()->route("owner.terapis.index")->with("success","Data terapis diperbarui.");
    }
    public function destroy($id) {
        Therapist::findOrFail($id)->update(["is_active"=>false]);
        return redirect()->route("owner.terapis.index")->with("success","Terapis dinonaktifkan.");
    }
    public function ulasan($id) {
        $therapist = Therapist::with("user")->findOrFail($id);
        $reviews   = \App\Models\Review::with("child.parent")->where("therapist_id",$id)->orderByDesc("created_at")->paginate(20);
        return view("owner.terapis-form", compact("therapist","reviews"))->with("tab","ulasan");
    }
    public function create() { return redirect()->route("owner.staf.create"); }
    public function store(Request $request) { return redirect()->route("owner.terapis.index"); }
    public function show($id) { return $this->edit($id); }
}
