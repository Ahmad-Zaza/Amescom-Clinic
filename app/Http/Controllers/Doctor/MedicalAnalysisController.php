<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalAnalysis;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MedicalAnalysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function getAllPatientMedicalAnalyses($patient_id)
    {
        $per_page = request()->per_page ?? 10;
        $patient_id = Crypt::decrypt($patient_id);

        $medicalAnalyses = MedicalAnalysis::sortable()->where('patient_id', $patient_id)
            ->paginate($per_page);

        return view('auth.doctor.patient-medicalAnalyses', [
            'medicalAnalyses' => $medicalAnalyses,
            'per_page' => $per_page,
        ]);
    }


    public function getSingleMedicalAnalysis($medicalAnalysis_id)
    {
        $medicalAnalysis_id =  Crypt::decrypt($medicalAnalysis_id);
        $medicalFolder = MedicalAnalysis::find($medicalAnalysis_id);
        $photos = $medicalFolder->getMedia('medicalAnalysis');


        return view('auth.doctor.medical-folder', [
            'medicalFolder' => $medicalFolder,
            'photos' => $photos,
        ]);
    }
}
