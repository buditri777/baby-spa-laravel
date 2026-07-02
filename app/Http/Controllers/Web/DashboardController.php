<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Payment;
use App\Models\Child;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $today = now("Asia/Jakarta")->toDateString();
        $scope = in_array($user->role, ["OWNER","SUPER_ADMIN"]) ? null : $user->branch_id;

        if ($user->role === "PARENT") {
            $recentBookings = Booking::with(["child","service","therapist"])
                ->whereHas("child", fn($q) => $q->where("parent_id", $user->id))
                ->orderByDesc("scheduled_date")->take(5)->get();
            $children = Child::where("parent_id", $user->id)->count();
            return view("dashboard", compact("recentBookings","children"));
        }

        if ($user->role === "THERAPIST") {
            $todayBookings = Booking::with(["child","service"])
                ->where("therapist_id", $user->id)
                ->whereDate("scheduled_date", $today)->get();
            return view("dashboard", compact("todayBookings"));
        }

        $qBooking = Booking::whereDate("scheduled_date", $today);
        $qRevenue = Payment::where("status","PAID")->whereMonth("paid_at", now()->month)->whereYear("paid_at", now()->year);
        if ($scope) {
            $qBooking->where("branch_id", $scope);
            $qRevenue->whereHas("booking", fn($b) => $b->where("branch_id", $scope));
        }

        return view("dashboard", [
            "bookingsToday"   => $qBooking->count(),
            "revenueMonth"    => $qRevenue->sum("amount"),
            "totalPatients"   => User::where("role","PARENT")->count(),
            "totalTherapists" => User::where("role","THERAPIST")->where("is_active",true)->count(),
            "recentBookings"  => Booking::with(["child","service","therapist"])
                ->when($scope, fn($q) => $q->where("branch_id", $scope))
                ->orderByDesc("scheduled_date")->take(10)->get(),
        ]);
    }

    public function ownerDashboard() { return $this->index(); }

    public function akun() {
        return view("akun", ["user" => auth()->user()]);
    }

    public function updateAkun(Request $request) {
        $request->validate(["name"=>"required|string|max:255"]);
        auth()->user()->update($request->only(["name","email","province","city","district","village","address_line","homecare_latitude","homecare_longitude"]));
        return back()->with("success","Profil diperbarui.");
    }
}
