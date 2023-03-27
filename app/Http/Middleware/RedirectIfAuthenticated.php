<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard != 'medical_person' && $guard != 'admin' && $guard != 'reception') {
            return \redirect()->back()->with('fail', 'You Cannot Access This');
        }
        if ($guard === 'medical_person') {
            if (Auth::guard('medical_person')->user()->type === 'doctor' && !$request->routeIs('doctor.*')) {
                return \redirect()->back()->with('fail', 'You can not access this !!');
            } elseif (Auth::guard('medical_person')->user()->type === 'analysis' && !$request->routeIs('laboratory-technician.*')) {
                return \redirect()->back()->with('fail', 'You can not access this !!');
            } elseif (Auth::guard('medical_person')->user()->type === 'radiograph' && !$request->routeIs('radiograph-technician.*')) {
                return \redirect()->back()->with('fail', 'You can not access this !!');
            }
        }


        // dd('we are in hhere');
        // if ($guard != 'medical_person') {
        //     if (Auth::user()->type === 'doctor') {
        //         return redirect()->route('doctor.dashboard');
        //     } elseif (Auth::user()->type === 'analysis') {
        //         return redirect()->route('labTech.dashboard');
        //     } else {
        //         return response('coming soon rad tech');
        //     }
        // } elseif ($guard === 'admin') {
        // } elseif ($guard === 'reception') {
        //     return redirect()->route('receptionist.dashboard');
        // }
        // if (!Auth::guard($guard)->check())
        //     return redirect()->back();
        return $next($request);
    }
}