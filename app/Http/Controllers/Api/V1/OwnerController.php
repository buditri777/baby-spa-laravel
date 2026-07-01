<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\Booking;
use App\Models\PayrollPeriod;
use App\Models\Payslip;
use App\Models\IgReservation;
use App\Models\TherapistDayActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    // Staff CRUD
    public function storeStaff(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string',
            'phone'     => 'required|unique:users,phone',
            'email'     => 'nullable|email|unique:users,email',
            'role'      => 'required|in:THERAPIST,RECEPTIONIST,DIREKTUR,ADMIN',
            'branch_id' => 'nullable|exists:branches,id',
            'password'  => 'required|min:8',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json($user, 201);
    }

    public function patients(Request $request)
    {
        $q = User::where('role','PARENT')->with('children');
        if ($s = $request->get('search')) $q->where('name','like',"%$s%");
        return response()->json($q->paginate(20));
    }

    public function resetPatientPassword(Request $request, string $id)
    {
        $request->validate(['password'=>'required|min:8']);
        User::findOrFail($id)->update(['password'=>Hash::make($request->password)]);
        return response()->json(['ok'=>true]);
    }

    // Payroll
    public function generatePayroll(Request $request)
    {
        $request->validate(['month'=>'required|integer|between:1,12','year'=>'required|integer','branch_id'=>'nullable|exists:branches,id']);
        $period = PayrollPeriod::firstOrCreate(
            ['year'=>$request->year,'month'=>$request->month,'branch_id'=>$request->branch_id],
            ['status'=>'DRAFT','created_by_id'=>$request->user()->id]
        );
        return response()->json($period->load('payslips.therapist'), 201);
    }

    public function finalizePayroll(Request $request, string $id)
    {
        $period = PayrollPeriod::findOrFail($id);
        $period->update(['status'=>'FINALIZED','finalized_at'=>now()]);
        return response()->json($period->fresh());
    }

    public function payrollRates(Request $request)
    {
        $therapists = User::where('role','THERAPIST')->with('therapistProfile')->get();
        return response()->json($therapists);
    }

    // Therapist active days
    public function storeTherapistActive(Request $request)
    {
        $request->validate(['therapist_id'=>'required','date'=>'required|date','branch_id'=>'nullable']);
        $record = TherapistDayActive::firstOrCreate(
            ['therapist_id'=>$request->therapist_id,'date'=>$request->date],
            ['branch_id'=>$request->branch_id,'created_by_id'=>$request->user()->id]
        );
        return response()->json($record, 201);
    }

    // IG reservasi
    public function reservasiIg(Request $request)
    {
        $scope = $request->user()->branchScope();
        $q = IgReservation::with(['user','service','handler'])->orderByDesc('created_at');
        return response()->json($q->paginate(20));
    }

    // Dashboard pusat
    public function dashboardPusat(Request $request)
    {
        $scope = $request->user()->branchScope();
        $today = now('Asia/Jakarta')->toDateString();

        $qBooking = Booking::whereDate('scheduled_at', $today);
        $qRevenue = \App\Models\Payment::where('status','PAID')->whereMonth('paid_at', now()->month);

        if ($scope) { $qBooking->where('branch_id',$scope); $qRevenue->whereHas('booking', fn($b)=>$b->where('branch_id',$scope)); }

        return response()->json([
            'bookings_today'  => $qBooking->count(),
            'revenue_month'   => $qRevenue->sum('amount'),
            'total_patients'  => User::where('role','PARENT')->count(),
            'total_therapists'=> User::where('role','THERAPIST')->where('is_active',true)->count(),
        ]);
    }

    // Operational hours
    public function hours(Request $request) {
        return response()->json(\App\Models\Setting::get('operational_hours', '08:00-17:00'));
    }
}
