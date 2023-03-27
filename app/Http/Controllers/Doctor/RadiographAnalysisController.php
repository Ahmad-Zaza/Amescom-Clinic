<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Radiograph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RadiographAnalysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function getAllPatientRadiographAnalyses($patient_id)
    {
        $per_page = request()->per_page ?? 10;
        $patient_id = Crypt::decrypt($patient_id);

        $radiographAnalyses = Radiograph::sortable()->where('patient_id', $patient_id)
            ->paginate($per_page);

        return view('auth.doctor.patient-radiographAnalyses', [
            'radiographAnalyses' => $radiographAnalyses,
            'per_page' => $per_page,
        ]);
    }


    public function getSingleRadiographAnalysis($radiographAnalysis_id)
    {
        $radiographAnalysis_id =  Crypt::decrypt($radiographAnalysis_id);
        $medicalFolder = Radiograph::find($radiographAnalysis_id);
        $photos = $medicalFolder->getMedia('radiographAnalysis');


        return view('auth.doctor.medical-folder', [
            'medicalFolder' => $medicalFolder,
            'photos' => $photos,
        ]);
    }
}