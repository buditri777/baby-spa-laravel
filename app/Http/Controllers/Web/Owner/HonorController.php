<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceRate;
use App\Models\TherapistFee;
use App\Models\Branch;
use Illuminate\Http\Request;

class HonorController extends Controller
{
    public function index(Request $request) {
        $user  = auth()->user();
        $year  = $request->year  ?? now()->year;
        $month = $request->month ?? now()->month;
        $q = Booking::with(['therapist','service','branch'])
            ->where('status','COMPLETED')
            ->whereYear('scheduled_date',$year)->whereMonth('scheduled_date',$month);
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) $q->where('branch_id',$user->branch_id);
        $bookings = $q->orderByDesc('scheduled_date')->paginate(30)->withQueryString();
        $therapists  = User::where('role','THERAPIST')->where('is_active',true)->get();
        $services    = Service::where('is_active',true)->get();
        $serviceRates= ServiceRate::with('service')->get()->keyBy('service_id');
        $branches    = Branch::where('is_active',true)->get();
        return view('owner.honor', compact('bookings','therapists','services','serviceRates','branches','year','month'));
    }
}
