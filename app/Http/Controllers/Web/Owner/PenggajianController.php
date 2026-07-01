<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index() { return view('owner.penggajian'); }
    public function create() { return view('owner.penggajian-form'); }
    public function store(Request $request) { return redirect()->back()->with('success','Berhasil disimpan.'); }
    public function show($id) { return view('owner.penggajian'); }
    public function edit($id) { return view('owner.penggajian-form'); }
    public function update(Request $request, $id) { return redirect()->back()->with('success','Berhasil diperbarui.'); }
    public function destroy($id) { return redirect()->back()->with('success','Berhasil dihapus.'); }
    public function ulasan($id = null) { return view('owner.penggajian'); }
}
