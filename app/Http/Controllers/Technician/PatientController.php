<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Visiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function getCurrentPatients($department_id)
    {
        $per_page = request()->per_page ?? 10;
        $department_id = Crypt::decrypt($department_id);
        $departments = Department::all();
        $visits = Visiting::sortable()->where('department_id', $department_id)
            ->where('status', 'pending')
            ->with('patient')
            ->paginate($per_page);

        return view('auth.LabTech.currenct_patient', [
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

    public function search()
    {
        $per_page = request()->per_page ?? 10;
        $searchs = explode(" ", request()->search);
        foreach ($searchs as $search) {
            $patients = Patient::sortable()
                // ->with(['medicalAnalyses' => function ($q) {
                //     $q->where('medical_person_id', '=',  Auth::guard('medical_person')->user()->id);
                // }])
                ->where('firstName', 'LIKE', "%{$search}%")
                ->orwhere('lastName', 'LIKE', "%{$search}%")
                ->orwhere('fatherName', 'LIKE', "%{$search}%")
                ->orwhere('nationaltyID', 'LIKE', "%{$search}%")
                ->paginate($per_page);
        }
        // return $patients;
        return view('auth.LabTech.medicalAnalysis-search', [
            'patients' => $patients,
            'per_page' => $per_page
        ]);
    }

    public function searchRad()
    {
        $per_page = request()->per_page ?? 10;
        $searchs = explode(" ", request()->search);
        foreach ($searchs as $search) {
            $patients = Patient::sortable()
                // ->with(['medicalAnalyses' => function ($q) {
                //     $q->where('medical_person_id', '=',  Auth::guard('medical_person')->user()->id);
                // }])
                ->where('firstName', 'LIKE', "%{$search}%")
                ->orwhere('lastName', 'LIKE', "%{$search}%")
                ->orwhere('fatherName', 'LIKE', "%{$search}%")
                ->orwhere('nationaltyID', 'LIKE', "%{$search}%")
                ->paginate($per_page);
        }
        // return $patients;
        return view('auth.RadTech.radiographAnalysis-search', [
            'patients' => $patients,
            'per_page' => $per_page
        ]);
    }
}