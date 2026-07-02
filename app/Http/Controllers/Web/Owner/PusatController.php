<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Branch;
use App\Models\Expense;
use Illuminate\Http\Request;

class PusatController extends Controller
{
    public function index(Request $request) {
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $branches = Branch::where("is_active",true)->withCount("bookings")->get();
        $stats = [];
        foreach ($branches as $br) {
            $revenue = Payment::where("status","PAID")
                ->whereHas("booking", fn($b) => $b->where("branch_id",$br->id))
                ->whereYear("paid_at",$year)->whereMonth("paid_at",$month)->sum("amount");
            $bookingCount = Booking::where("branch_id",$br->id)
                ->whereYear("scheduled_date",$year)->whereMonth("scheduled_date",$month)->count();
            $expense = Expense::where("branch_id",$br->id)
                ->whereYear("expense_date",$year)->whereMonth("expense_date",$month)->sum("amount");
            $stats[] = ["branch"=>$br,"revenue"=>$revenue,"bookings"=>$bookingCount,"expense"=>$expense,"net"=>$revenue-$expense];
        }
        $totalRevenue  = collect($stats)->sum("revenue");
        $totalBookings = collect($stats)->sum("bookings");
        $totalExpense  = collect($stats)->sum("expense");
        $totalNet      = $totalRevenue - $totalExpense;
        $therapistCount= User::where("role","THERAPIST")->where("is_active",true)->count();
        $patientCount  = User::where("role","PARENT")->count();
        return view("owner.pusat", compact("stats","totalRevenue","totalBookings","totalExpense","totalNet","therapistCount","patientCount","year","month","branches"));
    }
}
