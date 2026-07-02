<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    private array $keys = ["landing_email","landing_cs_phone","landing_services","landing_faq","privacy_policy"];

    public function index() {
        $settings = Setting::whereIn("key", $this->keys)->pluck("value","key");
        return view("owner.landing", compact("settings"));
    }

    public function update(Request $request) {
        foreach ($this->keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(["key"=>$key],["value"=>$request->$key ?? ""]);
            }
        }
        return redirect()->back()->with("success","Pengaturan landing disimpan.");
    }
}
