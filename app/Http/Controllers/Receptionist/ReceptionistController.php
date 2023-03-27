<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceptionistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:reception');
    }

    public function index()
    {
        // return response(Auth::guard('receptoin')->check());
        return view('auth.receptionist.welcome');
    }
}