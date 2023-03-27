<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */



    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except('logout');
    }

    public function login(Request $request)
    {

        // Validate the form data
        $this->validate($request, [
            'userName'   => 'required|string',
            'password' => 'required|min:6'
        ]);
        $credentials = $request->only('userName', 'password');

        // admin login
        if (Auth::guard('admin')->attempt($credentials) && $request->role == "1") {
            // return response($request->all());
            return redirect()->route('admin.dashboard');
        }

        // medical person login
        else if (Auth::guard('medical_person')->attempt([
            'userName' => $request->userName,
            'password' => $request->password
        ])) {
            // return $request->all();
            if ($request->role == 3)
                return redirect()->route('doctor.dashboard');
            elseif ($request->role == 4)
                return redirect()->route('laboratory-technician.dashboard');
            elseif ($request->role == 5)
                return \redirect()->route('radiograph-technician.dashboard');
        }
        // receptionist login
        elseif (Auth::guard('reception')->attempt([
            'userName' => $request->userName,
            'password' => $request->password
        ]) && $request->role == "2") {
            return redirect()->route('receptionist.dashboard');
        }
        // return response('no accpeting');
        return redirect()->back()->withInput($request->only('userName', 'password'))->with('fail', 'No Such User!!');
    }
}