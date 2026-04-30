<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
  /*  public function handle(Request $request, Closure $next): Response
    {
        // اگر کاربر لاگین است و نقش او Admin است
        if (Auth::check() && Auth::user()->role === 'Admin') {
            return $next($request);
        }

        // در غیر این صورت برگرد به صفحه لاگین
        return redirect()->route('login');
    }*/
public function handle(Request $request, Closure $next): Response
{
if (!Auth::check()) {
    return redirect()->route('login');
}

if (!Auth::user()->isAdmin()) { // ✅ استفاده از متد مدل
    abort(403);
}

    return $next($request);
}
}
