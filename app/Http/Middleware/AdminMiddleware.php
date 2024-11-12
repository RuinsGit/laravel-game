<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcının giriş yapmış ve admin olup olmadığını kontrol et
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Admin olmayan kullanıcıları ana sayfaya yönlendir
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}
