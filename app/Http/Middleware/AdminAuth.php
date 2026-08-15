<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من وجود جلسة دخول رسمية معتمدة من Auth
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['login_error' => 'يرجى تسجيل الدخول أولاً للوصول للوحة التحكم.']);
        }

        return $next($request);
    }
}