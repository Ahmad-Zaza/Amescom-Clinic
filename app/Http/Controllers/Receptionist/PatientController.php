<?php

namespace App\Http\Controllers\Receptionist;

use App\Events\ClinicNotification;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MedicalPerson;
use App\Models\Patient;
use App\Models\Visiting;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:reception');
    }

    public function getPatientsPage()
    {
        $per_page = request()->per_page ?? 10;
        $patients = Patient::sortable()->paginate($per_page);
        $departments = Department::where('type', '!=', 'reception')->get();

        return view('auth.receptionist.patient', [
            'patients' => $patients,
            'per_page' => $per_page,
            'departments' => $departments,
        ]);
    }

    public function transferPatient(Request $request, $patient_id)
    {
        $patient_id = Crypt::decrypt($patient_id);

        $check = Visiting::where('patient_id', $patient_id)
            ->where('department_id', $request->department_id)
            ->where('status', '!=', 'done')
            ->get();

        if ($check->count()) {
            return redirect()->back()
                ->with('fail', 'This patient has already been transformed to the selected department, You can not transform him again');
        }
        $request->validate([
            //   'patient_id' => 'required',
            'department_id' => 'required',
            'receptionist_id' => 'required',
        ]);

        $visiting = Visiting::create([
            'patient_id' => $patient_id,
            'department_id' => $request->department_id,
            'receptionist_id' => $request->receptionist_id,
        ]);
        // send notification to the department
        $patient = Patient::find($patient_id);
        $data = [
            'department_id' => $request->department_id,
            'msg' => "patient " .  $patient->firstName . " " . $patient->lastName . "has been transformed to you department",
        ];
        event(new ClinicNotification($data));
        //
        if ($visiting) {
            return redirect()->back()->with('success', 'patient has been transformed');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, failed to transfer patient ');
        }
    }

    public function getSearchPage()
    {
        $searchs = explode(" ", request()->search);
        // return $searchs;
        $per_page = request()->per_page ?? 10;
        $search = request()->search;
        if (!$search) {
            $patients = Patient::sortable()->paginate($per_page);
            $getAll = false;
        } else {
            foreach ($searchs as $search) {
                $patients = Patient::sortable()->where('firstName', 'LIKE', "%{$search}%")
                    ->orwhere('lastName', 'LIKE', "%{$search}%")
                    ->orwhere('lastName', 'LIKE', "%{$search}%")
                    ->orwhere('fatherName', 'LIKE', "%{$search}%")
                    ->orwhere('nationaltyID', 'LIKE', "%{$search}%")
                    ->paginate($per_page);
            }
            $getAll = true;
        }

        // Search each Name Field for any specified Name
        $departments = Department::where('type', '!=', 'reception')->get();
        return view('auth.receptionist.patient-search', [
            'per_page' => $per_page,
            'patients' => $patients,
            'departments' => $departments,
            'getAll' => $getAll,
        ]);
    }

    public function getAddForm()
    {
        return view('auth.receptionist.add-patient');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nationaltyID' => [
                'required',
                'numeric',
                Rule::unique('patients'),
            ],
            'phoneNumber' => 'required|string',
            'bloodSympol' => 'required|string',
            'gender' => 'required',
        ]);

        $patient = Patient::create([
            'firstName' => $request->firstName,
            'fatherName' => $request->fatherName,
            'lastName' => $request->lastName,
            'gender' => $request->gender,
            'nationaltyID' => $request->nationaltyID,
            'bloodSympol' => $request->bloodSympol,
            'phoneNumber' => $request->phoneNumber,
        ]);

        if ($patient) {
            return redirect()->route('receptionist.patient.search')->with('success', 'Patient has been created successfully ');
        } else
            return redirect()->route('receptionist.patient.search')->with('fail', 'Something get wrong !!');
    }

    public function getEditForm($patient_id)
    {
        $patient_id = Crypt::decrypt($patient_id);
        $patient = Patient::find($patient_id);
        return view('auth.receptionist.edit-patient', [
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, $patient_id)
    {
        // return $request->all();
        $patient_id = Crypt::decrypt($patient_id);
        // return $patient_id;
        $request->validate([
            'firstName' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nationaltyID' => [
                'required',
                'numeric',
                Rule::unique('patients')->ignore($patient_id),
            ],
            'phoneNumber' => 'required|string',
            'bloodSympol' => 'required|string',
            'gender' => 'required',
        ]);

        $patient = Patient::find($patient_id);

        $patient->update([
            'firstName' => $request->firstName,
            'fatherName' => $request->fatherName,
            'lastName' => $request->lastName,
            'gender' => $request->gender,
            'nationaltyID' => $request->nationaltyID,
            'bloodSympol' => $request->bloodSympol,
            'phoneNumber' => $request->phoneNumber,
        ]);

        return redirect()->route('receptionist.patient.search')->with('success', 'Patient has been updated successfully');
    }
}