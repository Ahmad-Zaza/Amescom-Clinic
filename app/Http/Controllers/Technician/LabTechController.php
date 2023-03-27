<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\MedicalAnalysis;
use App\Models\Radiograph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LabTechController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function index()
    {
        return view('auth.LabTech.welcome');
    }

    public function getMyMedicalAnalyses()
    {
        $per_page = request()->per_page ?? 10;
        $medicalAnalysis_id = auth()->user()->id;
        $medicalAnalyses = MedicalAnalysis::sortable()->where('medical_person_id', $medicalAnalysis_id)
            ->paginate($per_page);

        return view('auth.LabTech.MyMedicalAnalyses', [
            'per_page' => $per_page,
            'medicalAnalyses' => $medicalAnalyses,

        ]);
    }

    public function getPatientMedicalAnalyses($patient_id)
    {
        $patient_id = Crypt::decrypt($patient_id);
        $per_page = request()->per_page ?? 10;
        $medicalAnalyses = MedicalAnalysis::sortable()->where('patient_id', $patient_id)
            ->where('medical_person_id', Auth::user()->id)
            ->paginate($per_page);

        return view('auth.LabTech.MyMedicalAnalyses', [
            'per_page' => $per_page,
            'medicalAnalyses' => $medicalAnalyses,

        ]);
    }

    public function getPatientRadiographAnalyses($patient_id)
    {
        $patient_id = Crypt::decrypt($patient_id);
        $per_page = request()->per_page ?? 10;
        $radiographAnalyses = Radiograph::sortable()->where('patient_id', $patient_id)
            ->where('medical_person_id', Auth::user()->id)
            ->paginate($per_page);

        return view('auth.RadTech.MyRadiographAnalyses', [
            'per_page' => $per_page,
            'radiographAnalyses' => $radiographAnalyses,

        ]);
    }
}