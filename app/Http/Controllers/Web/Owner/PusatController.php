<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PusatController extends Controller
{
    public function index() { return view('owner.pusat'); }
    public function create() { return view('owner.pusat-form'); }
    public function store(Request $request) { return redirect()->back()->with('success','Berhasil disimpan.'); }
    public function show($id) { return view('owner.pusat'); }
    public function edit($id) { return view('owner.pusat-form'); }
    public function update(Request $request, $id) { return redirect()->back()->with('success','Berhasil diperbarui.'); }
    public function destroy($id) { return redirect()->back()->with('success','Berhasil dihapus.'); }
    public function ulasan($id = null) { return view('owner.pusat'); }
}
