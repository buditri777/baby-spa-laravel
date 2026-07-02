<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\IgReservation;
use Illuminate\Http\Request;

class ReservasiIgController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = IgReservation::orderByDesc("created_at");
        if (!in_array($user->role,["OWNER","SUPER_ADMIN"])) {
            $q->where("branch_id", $user->branch_id);
        }
        if ($request->status) $q->where("status",$request->status);
        $reservations = $q->paginate(20)->withQueryString();
        return view("owner.reservasi-ig", compact("reservations"));
    }
}
