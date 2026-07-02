<?php
namespace App\Http\Controllers\Web\Owner;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SosmedController extends Controller
{
    private array $keys = ["instagram_url","facebook_url","tiktok_url","youtube_url","whatsapp_url"];

    public function index() {
        $settings = Setting::whereIn("key", $this->keys)->pluck("value","key");
        return view("owner.sosmed", compact("settings"));
    }

    public function update(Request $request) {
        foreach ($this->keys as $key) {
            Setting::updateOrCreate(["key"=>$key],["value"=>$request->$key ?? ""]);
        }
        return redirect()->back()->with("success","Link sosmed disimpan.");
    }
}
