<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Branch;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    private array $keys = ['klinik_name','klinik_address','klinik_phone','klinik_email',
        'klinik_latitude','klinik_longitude','klinik_wa','klinik_description'];

    public function index() {
        $settings = Setting::whereIn('key', $this->keys)->pluck('value','key');
        $branches = Branch::where('is_active',true)->orderBy('name')->get();
        return view('owner.pengaturan', compact('settings','branches'));
    }

    public function update(Request $request) {
        foreach ($this->keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key'=>$key],['value'=>$request->$key]);
            }
        }
        return redirect()->back()->with('success','Pengaturan disimpan.');
    }
}
