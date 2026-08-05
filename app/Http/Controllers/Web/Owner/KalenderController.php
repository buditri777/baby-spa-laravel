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
        $startDt = \Carbon\Carbon::parse($start, 'Asia/Jakarta')->startOfDay();
        $endDt   = \Carbon\Carbon::parse($end,   'Asia/Jakarta')->endOfDay();
        $q = Booking::with(["child","service","therapist"])
            ->whereBetween("scheduled_at", [$startDt, $endDt])
            ->orderBy("scheduled_at");
        if (!in_array($user->role,["OWNER","SUPER_ADMIN"])) $q->where("branch_id",$user->branch_id);
        if ($request->branch_id) $q->where("branch_id",$request->branch_id);
        $bookings = $q->get()->groupBy(fn($b) => $b->scheduled_at->setTimezone('Asia/Jakarta')->toDateString());
        $therapists = User::where("role","THERAPIST")->where("is_active",true)->get();
        $branches   = Branch::where("is_active",true)->get();
        $dates      = collect(range(0,6))->map(fn($i) => \Carbon\Carbon::parse($start)->addDays($i)->toDateString());
        return view("owner.calendar", compact("bookings","therapists","branches","dates","start","end"));
    }
}
