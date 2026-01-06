<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'siswa') {
            return $next($request);
        }
        return redirect('/login')->withErrors('Anda bukan Siswa!');
    }
}
