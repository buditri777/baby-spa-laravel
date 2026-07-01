<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\User;
use App\Models\Branch;
use App\Models\Payslip;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function branchFilter($q, $user) {
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) $q->where('branch_id',$user->branch_id);
        return $q;
    }

    public function pendapatan(Request $request) {
        $user  = auth()->user();
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $q = Payment::with(['booking.service','booking.branch'])
            ->where('status','PAID')
            ->whereYear('paid_at',$year)->whereMonth('paid_at',$month);
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) {
            $q->whereHas('booking', fn($b) => $b->where('branch_id',$user->branch_id));
        }
        $payments = $q->orderByDesc('paid_at')->get();
        $total    = $payments->sum('amount');
        $byMethod = $payments->groupBy('payment_method')->map->sum('amount');
        $branches = Branch::where('is_active',true)->get();
        return view('owner.laporan', compact('payments','total','byMethod','year','month','branches'))->with('tab','pendapatan');
    }

    public function advanced(Request $request) {
        $user  = auth()->user();
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $q = Payment::with(['booking.service','booking.therapist'])
            ->where('status','PAID')
            ->whereYear('paid_at',$year)->whereMonth('paid_at',$month);
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) {
            $q->whereHas('booking', fn($b) => $b->where('branch_id',$user->branch_id));
        }
        $payments    = $q->get();
        $byService   = $payments->groupBy(fn($p) => $p->booking?->service?->name ?? '-')->map->sum('amount');
        $byTherapist = $payments->groupBy(fn($p) => $p->booking?->therapist?->name ?? '-')->map->sum('amount');
        return view('owner.laporan', compact('payments','byService','byTherapist','year','month'))->with('tab','advanced');
    }

    public function pembukuan(Request $request) {
        $user  = auth()->user();
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $income = Payment::where('status','PAID')->whereYear('paid_at',$year)->whereMonth('paid_at',$month)
            ->when(!in_array($user->role,['OWNER','SUPER_ADMIN']), fn($q)=>$q->whereHas('booking',fn($b)=>$b->where('branch_id',$user->branch_id)))
            ->sum('amount');
        $expense = Expense::whereYear('expense_date',$year)->whereMonth('expense_date',$month)
            ->when(!in_array($user->role,['OWNER','SUPER_ADMIN']), fn($q)=>$q->where('branch_id',$user->branch_id))
            ->sum('amount');
        $net = $income - $expense;
        return view('owner.laporan', compact('income','expense','net','year','month'))->with('tab','pembukuan');
    }

    public function pajak(Request $request) {
        $user = auth()->user();
        $year = $request->year ?? now()->year;
        $q = Payment::where('status','PAID')->whereYear('paid_at',$year)
            ->when(!in_array($user->role,['OWNER','SUPER_ADMIN']), fn($q)=>$q->whereHas('booking',fn($b)=>$b->where('branch_id',$user->branch_id)));
        $byMonth = collect(range(1,12))->mapWithKeys(fn($m)=>[$m=>$q->clone()->whereMonth('paid_at',$m)->sum('amount')]);
        $total   = $byMonth->sum();
        return view('owner.laporan', compact('byMonth','total','year'))->with('tab','pajak');
    }

    public function referral(Request $request) {
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $data = User::where('role','PARENT')
            ->whereYear('created_at',$year)->whereMonth('created_at',$month)
            ->selectRaw('referral_source, count(*) as total')
            ->groupBy('referral_source')->orderByDesc('total')->get();
        return view('owner.laporan', compact('data','year','month'))->with('tab','referral');
    }
}
