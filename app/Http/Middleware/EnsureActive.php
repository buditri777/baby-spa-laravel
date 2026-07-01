<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class EnsureActive
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && !$request->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['login' => 'Akun tidak aktif.']);
        }
        return $next($request);
    }
}
