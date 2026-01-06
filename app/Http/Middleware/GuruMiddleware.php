<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'guru') {
            return $next($request);
        }
        return redirect('/login')->withErrors('Anda bukan Guru!');
    }
}
