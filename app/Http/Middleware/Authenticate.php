<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            // dd('we are in hhere');
            // return \redirect()->back();
            if (Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            } elseif (Auth::guard('medical_person')->check()) {
                if (Auth::guard('medical_person')->user()->type === 'doctor')
                    return route('doctor.dashboard');
                elseif (Auth::guard('medical_person')->user()->type === 'analysis')
                    return route('labTech.dashboard');
                elseif (Auth::guard('medical_person')->user()->type === 'radiograph')
                    return route('radiograph-technician.dashboard');
            } elseif (Auth::guard('reception')->check()) {
                return route('receptionist.dashboard');
            }
            return route('login');
        }
    }
}