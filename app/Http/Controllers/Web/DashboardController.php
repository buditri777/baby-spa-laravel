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
                ->orderByDesc("scheduled_at")->take(5)->get();
            $children = Child::where("parent_id", $user->id)->count();
            return view("dashboard", compact("recentBookings","children"));
        }

        if ($user->role === "THERAPIST") {
            $todayBookings = Booking::with(["child","service"])
                ->where("therapist_id", $user->id)
                ->whereDate("scheduled_at", $today)->get();
            return view("dashboard", compact("todayBookings"));
        }

        $tz         = 'Asia/Jakarta';
        $todayStart = now($tz)->startOfDay();
        $todayEnd   = now($tz)->endOfDay();
        $monthStart = now($tz)->startOfMonth();
        $sevenDaysAgo = now($tz)->subDays(7);

        // Today bookings (CONFIRMED + COMPLETED)
        $qBooking = Booking::whereBetween('scheduled_at', [$todayStart, $todayEnd])
            ->whereIn('status', ['CONFIRMED','COMPLETED','REQUESTED']);
        if ($scope) $qBooking->where('branch_id', $scope);
        $bookingsToday = $qBooking->count();

        // Month revenue
        $qRevMonth = Payment::where('status','PAID')
            ->whereBetween('paid_at', [$monthStart, now($tz)]);
        if ($scope) $qRevMonth->whereHas('booking', fn($b) => $b->where('branch_id', $scope));
        $revenueMonth = $qRevMonth->sum('amount');

        // Today revenue
        $qRevToday = Payment::where('status','PAID')
            ->whereBetween('paid_at', [$todayStart, $todayEnd]);
        if ($scope) $qRevToday->whereHas('booking', fn($b) => $b->where('branch_id', $scope));
        $todayRevenue   = $qRevToday->sum('amount');
        $todayPaidCount = $qRevToday->count();

        // Today sessions
        $todaySessions = \App\Models\Session::whereBetween('ended_at', [$todayStart, $todayEnd])->count();

        // Tren 7 hari
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $d    = now($tz)->subDays($i)->startOfDay();
            $dEnd = $d->copy()->endOfDay();
            $q = Payment::where('status','PAID')->whereBetween('paid_at', [$d, $dEnd]);
            if ($scope) $q->whereHas('booking', fn($b) => $b->where('branch_id', $scope));
            $trend[] = [
                'label' => $d->locale('id')->isoFormat('ddd'),
                'total' => (float) $q->sum('amount'),
            ];
        }
        $trendMax = max(1, ...array_column($trend, 'total'));

        // New patients 7 days
        $newPatients       = Child::where('created_at', '>=', $sevenDaysAgo)->count();
        $recentNewPatients = Child::with('parent:id,name,phone,referral_source')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->orderByDesc('created_at')->take(8)->get();

        return view('dashboard', [
            'bookingsToday'      => $bookingsToday,
            'revenueMonth'       => $revenueMonth,
            'todayRevenue'       => $todayRevenue,
            'todayPaidCount'     => $todayPaidCount,
            'todaySessions'      => $todaySessions,
            'trend'              => $trend,
            'trendMax'           => $trendMax,
            'totalPatients'      => User::where('role','PARENT')->count(),
            'totalTherapists'    => User::where('role','THERAPIST')->where('is_active',true)->count(),
            'newPatients'        => $newPatients,
            'recentNewPatients'  => $recentNewPatients,
            'recentBookings'     => Booking::with(['child','service','therapist'])
                ->when($scope, fn($q) => $q->where('branch_id', $scope))
                ->orderByDesc('scheduled_at')->take(10)->get(),
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
