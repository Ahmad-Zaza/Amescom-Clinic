<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->type != "doctor") {
            return redirect()->back();
        }
        return $next($request);
    }
}