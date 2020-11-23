<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() and Auth::user()->role_id == 3) {
            return $next($request);
        }
        return redirect('/');
    }
}
