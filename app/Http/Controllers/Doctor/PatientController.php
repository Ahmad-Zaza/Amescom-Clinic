<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\CurrentPatient;
use App\Models\Department;
use App\Models\MedicalPerson;
use App\Models\Patient;
use App\Models\Visiting;
use Database\Seeders\RequestSeeder;
use Faker\Provider\Medical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PatientController extends Controller
{



    public function getCurrentPatients($department_id)
    {
        $per_page = request()->per_page ?? 10;
        $department_id = Crypt::decrypt($department_id);
        $departments = Department::where('type', '!=', 'reception')->where('id', '!=', $department_id)->get();
        $visits = Visiting::sortable()->where('department_id', $department_id)
            ->where('status', 'pending')
            ->with('patient')
            ->paginate($per_page);

        return view('auth.doctor.current_patients', [
            'visits' => $visits,
            'departments' => $departments,
            'per_page' => $per_page
        ]);
    }


    public function receiptPatient(Request $request)
    {
        $request->validate([
            'visiting_id' => 'required',
        ]);

        $visit = Visiting::find($request->visiting_id);
        $visit['status'] = 'pending';
        $visit->save();
        return redirect()->back()
            ->with('success', 'You Accept Patient');
    }

    public function getMedicalHistory($patient_id)
    {
        $patient_id = Crypt::decrypt($patient_id);

        $patient = Patient::find($patient_id);
        $perscription_count = $patient->prescriptions()->count();
        $medicalAnalysis_count = $patient->medicalAnalyses()->count();
        $radiographs_count = $patient->radiographs()->count();
        // return $perscription_count;

        return view('auth.doctor.medical_history', [
            'perscriptions_count' => $perscription_count,
            'medicalAnalysis_count' => $medicalAnalysis_count,
            'radiographs_count' => $radiographs_count,
            'patient_id' => $patient_id,
        ]);
    }

    public function transferPatient(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'department_id' => 'required',
        ]);

        $visiting = Visiting::create([
            'patient_id' => $request->patient_id,
            'department_id' => $request->department_id,
            'receptionist_id' => -1,
        ]);

        if ($visiting) {
            return redirect()->back()->with('success', 'patient has been transformed');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, failed to transfer patient ');
        }
    }

    public function search()
    {
        $per_page = request()->per_page ?? 10;
        $searchs = explode(" ", request()->search);
        foreach ($searchs as $search) {
            $patients = Patient::sortable()
                ->where('firstName', 'LIKE', "%{$search}%")
                ->orwhere('lastName', 'LIKE', "%{$search}%")
                ->orwhere('fatherName', 'LIKE', "%{$search}%")
                ->orwhere('nationaltyID', 'LIKE', "%{$search}%")
                ->paginate($per_page);
        }

        return view('auth.doctor.patients-search', [
            'patients' => $patients,
            'per_page' => $per_page
        ]);
    }
}