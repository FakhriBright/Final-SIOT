<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('login')) {
            return redirect('/login');
        }

        return $next($request);
    }
}