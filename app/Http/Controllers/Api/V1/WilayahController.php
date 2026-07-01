<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    private string $base = 'https://wilayah.id/api';

    public function provinces() {
        return $this->proxy('provinces');
    }
    public function regencies(string $code) {
        return $this->proxy("regencies/{$code}");
    }
    public function districts(string $code) {
        return $this->proxy("districts/{$code}");
    }
    public function villages(string $code) {
        return $this->proxy("villages/{$code}");
    }

    private function proxy(string $path) {
        $data = Cache::remember("wilayah_{$path}", 25200, function () use ($path) {
            $res = Http::timeout(10)->get("{$this->base}/{$path}.json");
            return $res->ok() ? $res->json() : ['data' => []];
        });
        return response()->json($data);
    }
}
