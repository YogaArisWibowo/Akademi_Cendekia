<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
   public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login DAN role-nya admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang ke halaman login atau error 403
        return redirect('/login')->withErrors('Anda bukan Admin!');
    }
}
