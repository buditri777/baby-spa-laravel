<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now('Asia/Jakarta')->toDateString();

        if ($user->role === 'PARENT') {
            $recentBookings = Booking::with(['child','service','therapist'])
                ->whereHas('child', fn($q) => $q->where('parent_id', $user->id))
                ->orderByDesc('scheduled_at')->take(5)->get();
            return view('dashboard', compact('recentBookings'));
        }

        $scope = $user->branchScope();
        $qBooking = Booking::whereDate('scheduled_at', $today);
        $qRevenue = Payment::where('status','PAID')->whereMonth('paid_at', now()->month);
        if ($scope) {
            $qBooking->where('branch_id', $scope);
            $qRevenue->whereHas('booking', fn($b) => $b->where('branch_id', $scope));
        }

        return view('dashboard', [
            'bookingsToday'   => $qBooking->count(),
            'revenueMonth'    => $qRevenue->sum('amount'),
            'totalPatients'   => User::where('role','PARENT')->count(),
            'totalTherapists' => User::where('role','THERAPIST')->where('is_active',true)->count(),
            'recentBookings'  => Booking::with(['child','service','therapist'])
                ->when($scope, fn($q) => $q->where('branch_id', $scope))
                ->orderByDesc('scheduled_at')->take(10)->get(),
        ]);
    }

    public function ownerDashboard() { return $this->index(); }

    public function akun() { return view('akun'); }

    public function updateAkun(Request $request)
    {
        $request->validate(['name'=>'required|string|max:255']);
        auth()->user()->update($request->only(['name','email','province','city','district','village','address_line']));
        return back()->with('success','Profil diperbarui.');
    }
}
