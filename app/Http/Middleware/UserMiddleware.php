<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
   /* public function handle(Request $request, Closure $next): Response
    {

        // اگر کاربر لاگین است و نقش او user است
        if (Auth::check() && strtolower(Auth::user()->role) === 'user') {
            return $next($request);
        }

        // اگر admin باشد بفرست به dashboard
        if (Auth::check() && strtolower(Auth::user()->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // اگر لاگین نبود
        return redirect()->route('login');
    }*/
public function handle(Request $request, Closure $next): Response
{
    //dd(Auth::user()->role);
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $role = strtolower(trim(Auth::user()->role));

    if ($role === 'user') {
        return $next($request);
    }

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // اگر role خراب بود
    Auth::logout();
    return redirect()->route('login');
}
}
