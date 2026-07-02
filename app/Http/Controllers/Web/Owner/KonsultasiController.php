<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\User;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = Consultation::with(["parent","child","therapist"])->orderByDesc("updated_at");
        if (!in_array($user->role,["OWNER","SUPER_ADMIN"])) {
            $q->whereHas("parent", fn($p) => $p->whereHas("bookingsAsParent", fn($b) => $b->where("branch_id",$user->branch_id)));
        }
        if ($request->status) $q->where("status",$request->status);
        $konsultasi = $q->paginate(20)->withQueryString();
        return view("owner.konsultasi", compact("konsultasi"));
    }
    public function show($id) {
        $konsul = Consultation::with(["parent","child","messages.sender","therapist"])->findOrFail($id);
        $therapists = User::where("role","THERAPIST")->where("is_active",true)->get();
        return view("owner.konsultasi", compact("konsul","therapists"))->with("detail",true);
    }
    public function update(Request $request, $id) {
        $konsul = Consultation::findOrFail($id);
        if ($request->action === "claim") {
            $konsul->update(["therapist_id"=>auth()->id(),"status"=>"CLAIMED"]);
        } elseif ($request->action === "close") {
            $konsul->update(["status"=>"CLOSED","closed_at"=>now()]);
        } elseif ($request->message) {
            ConsultationMessage::create([
                "id"              => "cm-".uniqid(),
                "consultation_id" => $id,
                "sender_id"       => auth()->id(),
                "message"         => $request->message,
            ]);
            $konsul->touch();
        }
        return redirect()->back()->with("success","Konsultasi diperbarui.");
    }
    public function store(Request $request) { return redirect()->back(); }
    public function create() { return redirect()->route("owner.konsultasi"); }
    public function edit($id) { return redirect()->route("owner.konsultasi"); }
    public function destroy($id) { return redirect()->back(); }
}
