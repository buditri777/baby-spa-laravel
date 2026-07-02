<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\Child;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function index(Request $request) {
        $q = Milestone::with(["child.parent"])->orderByDesc("achieved_at");
        if ($request->search) $q->whereHas("child", fn($c) => $c->where("name","like","%{$request->search}%"));
        $milestones = $q->paginate(20)->withQueryString();
        return view("owner.milestone", compact("milestones"));
    }
    public function create() {
        $children = Child::with("parent")->orderBy("name")->get();
        return view("owner.milestone", compact("children"))->with("form",true);
    }
    public function store(Request $request) {
        $data = $request->validate(["child_id"=>"required","title"=>"required|string","category"=>"nullable|string","achieved_at"=>"required|date","notes"=>"nullable|string"]);
        $data["id"] = "ms-".uniqid();
        Milestone::create($data);
        return redirect()->route("owner.milestone")->with("success","Milestone ditambahkan.");
    }
    public function destroy($id) {
        Milestone::findOrFail($id)->delete();
        return redirect()->back()->with("success","Milestone dihapus.");
    }
}
