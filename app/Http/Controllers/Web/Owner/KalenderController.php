<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request) {
        $user  = auth()->user();
        $start = $request->start ?? now("Asia/Jakarta")->startOfWeek()->toDateString();
        $end   = \Carbon\Carbon::parse($start)->addDays(6)->toDateString();
        $q = Booking::with(["child","service","therapist"])
            ->whereBetween("scheduled_date",[$start,$end])
            ->orderBy("scheduled_date")->orderBy("scheduled_time");
        if (!in_array($user->role,["OWNER","SUPER_ADMIN"])) $q->where("branch_id",$user->branch_id);
        if ($request->branch_id) $q->where("branch_id",$request->branch_id);
        $bookings   = $q->get()->groupBy("scheduled_date");
        $therapists = User::where("role","THERAPIST")->where("is_active",true)->get();
        $branches   = Branch::where("is_active",true)->get();
        $dates      = collect(range(0,6))->map(fn($i) => \Carbon\Carbon::parse($start)->addDays($i)->toDateString());
        return view("owner.calendar", compact("bookings","therapists","branches","dates","start","end"));
    }
}
