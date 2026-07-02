<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Child;
use App\Models\Service;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;

class WalkInController extends Controller
{
    public function index() {
        $user       = auth()->user();
        $children   = Child::with("parent")->orderBy("name")->get();
        $services   = Service::where("is_active",true)->get();
        $therapists = User::where("role","THERAPIST")->where("is_active",true)->get();
        $branches   = Branch::where("is_active",true)->get();
        return view("owner.walk-in", compact("children","services","therapists","branches"));
    }
    public function store(Request $request) {
        $data = $request->validate([
            "child_id"      => "required|string",
            "service_id"    => "required|string",
            "therapist_id"  => "nullable|string",
            "branch_id"     => "required|string",
            "scheduled_date"=> "required|date",
            "scheduled_time"=> "required",
            "notes"         => "nullable|string",
        ]);
        $data["id"]           = "bk-".uniqid();
        $data["booking_code"] = strtoupper(substr(uniqid(),0,8));
        $data["status"]       = "CONFIRMED";
        $data["is_homecare"]  = false;
        Booking::create($data);
        return redirect()->route("owner.booking.index")->with("success","Walk-in booking dibuat.");
    }
}
