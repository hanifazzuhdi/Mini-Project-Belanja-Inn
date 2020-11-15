<?php

namespace App\Http\Middleware;

use Closure;

class CekAdmin
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->role_id != 3) {
            return redirect('/');
        }
        return $next($request);
    }
}
