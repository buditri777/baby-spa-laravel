<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request) {
        $q = AuditLog::with("user")->orderByDesc("created_at");
        if ($request->search) $q->where(fn($s)=>$s->where("action","like","%{$request->search}%")->orWhere("target_type","like","%{$request->search}%"));
        if ($request->user_id) $q->where("user_id",$request->user_id);
        $logs = $q->paginate(30)->withQueryString();
        return view("owner.audit", compact("logs"));
    }
}
