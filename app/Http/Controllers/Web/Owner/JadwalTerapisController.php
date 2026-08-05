<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Therapist;
use App\Models\TherapistDayActive;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalTerapisController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $date = $request->date ?? now("Asia/Jakarta")->toDateString();

        // Ambil terapis via User (is_active ada di users, bukan therapists)
        $qT = User::where('role','THERAPIST')->where('is_active',true)
            ->with(['therapist']);
        if (!in_array($user->role,["OWNER","SUPER_ADMIN"])) $qT->where('branch_id',$user->branch_id);
        $therapists = $qT->orderBy('name')->get();

        // Ambil status aktif hari ini
        $dayActives = TherapistDayActive::whereDate('date', $date)
            ->get()->keyBy('therapist_id');

        $branches = Branch::where("is_active",true)->get();
        return view("owner.jadwal-terapis", compact("therapists","date","branches","dayActives"));
    }
    public function store(Request $request) {
        $data = $request->validate(["therapist_id"=>"required","date"=>"required|date","is_active"=>"boolean"]);
        TherapistDayActive::updateOrCreate(
            ["therapist_id"=>$data["therapist_id"],"date"=>$data["date"]],
            ["id"=>"tda-".uniqid(),"is_active"=>$request->boolean("is_active",true)]
        );
        return redirect()->back()->with("success","Jadwal diperbarui.");
    }
}
