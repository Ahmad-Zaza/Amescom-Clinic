<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\MedicalPerson;
use App\Models\Patient;
use App\Models\Visiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // $avatars = auth()->user()->getMedia();
        // return $avatars;
        // dd('we are in hhere');
        return view('auth.admin.admin');
    }

    public function addAvatar(Request $request)
    {
        $admin = auth()->user();
        $admin->addMedia($request->avatar)
            ->toMediaCollection();

        return redirect()->back();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/login');
    }
}