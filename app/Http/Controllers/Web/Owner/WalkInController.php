<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalkInController extends Controller
{
    public function index() { return view('owner.walk-in'); }
    public function create() { return view('owner.walk-in-form'); }
    public function store(Request $request) { return redirect()->back()->with('success','Berhasil disimpan.'); }
    public function show($id) { return view('owner.walk-in'); }
    public function edit($id) { return view('owner.walk-in-form'); }
    public function update(Request $request, $id) { return redirect()->back()->with('success','Berhasil diperbarui.'); }
    public function destroy($id) { return redirect()->back()->with('success','Berhasil dihapus.'); }
    public function ulasan($id = null) { return view('owner.walk-in'); }
}
