<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // public function __construct()
    // {
    //   $this->middleware('guest:admin', ['except' => ['logout']]);
    // }

    // public function showLoginForm()
    // {
    //   return view('auth.admin.admin_login');
    // }

    // public function login(Request $request)
    // {
    //   // Validate the form data
    //   $this->validate($request, [
    //     'FirstName'   => 'required|string',
    //     'password' => 'required|min:6'
    //   ]);

    // //   return response($request->all());
    //   // Attempt to log the user in
    //   if (Auth::guard('admin')->attempt(['FirstName' => $request->FirstName, 'password' => $request->password])) {
    //     // if successful, then redirect to their intended location
    //     // return response($request->all());
    //     return redirect()->intended(route('admin.dashboard'));
    //   }
    //   else if(Auth::guard('doctor')->attempt(['FirstName' => $request->FirstName, 'password' => $request->password])){
    //       //return response('guard');
    //       return redirect()->intended(route('admin.dashboard'));
    //   }
    //   // if unsuccessful, then redirect back to the login with the form data
    //   return redirect()->back()->withInput($request->only('email', 'remember'));
    // }

    // public function logout()
    // {
    //     Auth::guard('admin')->logout();
    //     return redirect('/admin/login');
    // }
}
