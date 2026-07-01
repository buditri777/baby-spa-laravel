<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\PayrollPeriod;
use App\Models\Payslip;
use App\Models\Branch;
use App\Models\User;
use App\Models\Booking;
use App\Models\TherapistFee;
use App\Models\ServiceRate;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index(Request $request) {
        $user    = auth()->user();
        $year    = $request->year  ?? now()->year;
        $month   = $request->month ?? now()->month;
        $q = PayrollPeriod::with(['branch','payslips.therapist']);
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) $q->where('branch_id',$user->branch_id);
        if ($request->year)  $q->where('year',$year);
        if ($request->month) $q->where('month',$month);
        $periods  = $q->orderByDesc('year')->orderByDesc('month')->paginate(10)->withQueryString();
        $branches = Branch::where('is_active',true)->get();
        return view('owner.penggajian', compact('periods','branches','year','month'));
    }

    public function create() {
        $branches = Branch::where('is_active',true)->get();
        return view('owner.penggajian-form', compact('branches'));
    }

    public function store(Request $request) {
        $data = $request->validate(['branch_id'=>'required','year'=>'required|integer','month'=>'required|integer|between:1,12']);
        $period = PayrollPeriod::firstOrCreate(
            ['branch_id'=>$data['branch_id'],'year'=>$data['year'],'month'=>$data['month']],
            ['id'=>'pp-'.uniqid(),'status'=>'DRAFT']
        );
        // generate payslips
        $therapists = User::where('role','THERAPIST')->where('branch_id',$data['branch_id'])->where('is_active',true)->get();
        foreach ($therapists as $t) {
            $sessions = Booking::where('therapist_id',$t->id)->where('status','COMPLETED')
                ->whereYear('scheduled_date',$data['year'])->whereMonth('scheduled_date',$data['month'])->with('service')->get();
            $sessionFee = 0;
            foreach ($sessions as $b) {
                $rate = ServiceRate::where('service_id',$b->service_id)->first();
                $fee  = TherapistFee::where('therapist_id',$t->therapist?->id)->where('service_id',$b->service_id)->first();
                if ($rate) {
                    $sessionFee += $rate->fee_type === 'FLAT' ? $rate->fee_value : ($b->service->price * $rate->fee_value / 100);
                } elseif ($fee) {
                    $sessionFee += $fee->fee_type === 'FLAT' ? $fee->fee_value : ($b->service->price * $fee->fee_value / 100);
                } else {
                    $sessionFee += $t->therapist?->honor_per_session ?? 0;
                }
            }
            $base = $t->therapist?->base_salary ?? 0;
            Payslip::updateOrCreate(
                ['payroll_period_id'=>$period->id,'therapist_id'=>$t->id],
                ['id'=>'ps-'.uniqid(),'base_salary'=>$base,'session_fee'=>$sessionFee,'session_count'=>$sessions->count(),'net_salary'=>$base+$sessionFee,'status'=>'DRAFT']
            );
        }
        return redirect()->route('owner.penggajian.show',$period->id)->with('success','Periode penggajian dibuat.');
    }

    public function show($id) {
        $period = PayrollPeriod::with(['payslips.therapist','branch'])->findOrFail($id);
        return view('owner.penggajian-form', compact('period'));
    }

    public function update(Request $request, $id) {
        $period = PayrollPeriod::findOrFail($id);
        if ($request->action === 'finalize') {
            $period->update(['status'=>'FINALIZED','finalized_at'=>now()]);
            Payslip::where('payroll_period_id',$id)->update(['status'=>'FINALIZED']);
        } elseif ($request->action === 'reopen') {
            $period->update(['status'=>'DRAFT','finalized_at'=>null]);
            Payslip::where('payroll_period_id',$id)->update(['status'=>'DRAFT']);
        } elseif ($request->payslip_id) {
            Payslip::findOrFail($request->payslip_id)->update(['notes'=>$request->notes,'net_salary'=>$request->net_salary]);
        }
        return redirect()->back()->with('success','Penggajian diperbarui.');
    }

    public function destroy($id) {
        PayrollPeriod::findOrFail($id)->delete();
        return redirect()->route('owner.penggajian.index')->with('success','Periode dihapus.');
    }
}
