<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Branch;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $q = Expense::with('branch');
        if (!in_array($user->role,['OWNER','SUPER_ADMIN'])) $q->where('branch_id',$user->branch_id);
        if ($request->month) $q->whereMonth('expense_date', date('m', strtotime($request->month.'-01')))
                               ->whereYear('expense_date',  date('Y', strtotime($request->month.'-01')));
        if ($request->search) $q->where('description','like',"%{$request->search}%");
        $expenses = $q->orderByDesc('expense_date')->paginate(20)->withQueryString();
        $total    = $q->sum('amount');
        $branches = Branch::where('is_active',true)->get();
        return view('owner.pengeluaran', compact('expenses','total','branches'));
    }
    public function create() {
        $branches = Branch::where('is_active',true)->get();
        return view('owner.pengeluaran-form', compact('branches'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category'     => 'nullable|string',
            'branch_id'    => 'nullable|string',
        ]);
        Expense::create($data);
        return redirect()->route('owner.pengeluaran.index')->with('success','Pengeluaran ditambahkan.');
    }
    public function edit($id) {
        $expense  = Expense::findOrFail($id);
        $branches = Branch::where('is_active',true)->get();
        return view('owner.pengeluaran-form', compact('expense','branches'));
    }
    public function update(Request $request, $id) {
        Expense::findOrFail($id)->update($request->only(['description','amount','expense_date','category','branch_id']));
        return redirect()->route('owner.pengeluaran.index')->with('success','Pengeluaran diperbarui.');
    }
    public function destroy($id) {
        Expense::findOrFail($id)->delete();
        return redirect()->route('owner.pengeluaran.index')->with('success','Pengeluaran dihapus.');
    }
}
