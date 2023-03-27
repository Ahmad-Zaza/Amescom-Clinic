<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function index()
    {
        return view('auth.doctor.doctor');
    }

    public function logout()
    {
        Auth::guard('medical_person')->logout();
        return redirect('/login');
    }
}