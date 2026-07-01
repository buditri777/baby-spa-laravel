<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Payslip;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pendapatan(Request $request)
    {
        $user  = $request->user();
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);
        $scope = $user->branchScope();

        $q = Payment::with(['booking.service','booking.branch'])
            ->where('status', 'PAID')
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month);

        if ($scope) $q->whereHas('booking', fn($b) => $b->where('branch_id', $scope));

        $payments = $q->get();
        return response()->json([
            'total'    => $payments->sum('amount'),
            'count'    => $payments->count(),
            'payments' => $payments,
        ]);
    }

    public function advanced(Request $request)
    {
        $user  = $request->user();
        $year  = $request->get('year', now()->year);
        $scope = $user->branchScope();

        $q = Payment::where('status','PAID')->whereYear('paid_at', $year);
        if ($scope) $q->whereHas('booking', fn($b) => $b->where('branch_id', $scope));

        $byMonth = $q->get()->groupBy(fn($p) => date('m', strtotime($p->paid_at)));
        return response()->json(['by_month' => $byMonth]);
    }

    public function pembukuan(Request $request)
    {
        $user  = $request->user();
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);
        $scope = $user->branchScope();

        $incomeQ = Payment::where('status','PAID')->whereYear('paid_at',$year)->whereMonth('paid_at',$month);
        $expenseQ = Expense::whereYear('expense_date',$year)->whereMonth('expense_date',$month);

        if ($scope) {
            $incomeQ->whereHas('booking', fn($b) => $b->where('branch_id', $scope));
            $expenseQ->where('branch_id', $scope);
        }

        $income   = $incomeQ->sum('amount');
        $expenses = $expenseQ->sum('amount');
        return response()->json(['income'=>$income,'expenses'=>$expenses,'profit'=>$income-$expenses]);
    }

    public function pajak(Request $request)
    {
        $year  = $request->get('year', now()->year);
        $scope = $request->user()->branchScope();

        $q = Payment::where('status','PAID')->whereYear('paid_at',$year);
        if ($scope) $q->whereHas('booking', fn($b) => $b->where('branch_id',$scope));

        $total = $q->sum('amount');
        return response()->json(['year'=>$year,'gross_revenue'=>$total,'tax_estimate_05'=>$total*0.005]);
    }

    public function referral(Request $request)
    {
        $stats = \App\Models\User::where('role','PARENT')
            ->whereNotNull('referral_source')
            ->selectRaw('referral_source, count(*) as total')
            ->groupBy('referral_source')
            ->orderByDesc('total')
            ->get();
        return response()->json($stats);
    }
}
