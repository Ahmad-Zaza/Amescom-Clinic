<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\MedicalPerson;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:receptionist');
    }

    public function getDoctorsPage()
    {
        $doctors = MedicalPerson::where('type', 'doctor');

        return view('auth.receptionist.doctor', [
            'doctors' => $doctors->paginate(20),
        ]);
    }
}