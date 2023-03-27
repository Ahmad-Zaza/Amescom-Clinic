<?php

namespace App\Http\Controllers\Admin;

use App\Events\ClinicNotification;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MedicalPerson;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getDoctorsPage()
    {
        $searchs = explode(" ", request()->search);
        $per_page = request()->per_page ?? 10;
        $search = request()->search;
        if (!$search) {
            $doctors = MedicalPerson::sortable()->where('type', 'doctor')
                ->paginate($per_page);
            $tag = false;
        } else {
            foreach ($searchs as $search) {
                $doctors = MedicalPerson::sortable()->where('type', 'doctor')
                    ->where('firstName', 'LIKE', "%{$search}%")
                    ->orwhere('lastName', 'LIKE', "%{$search}%")
                    ->orwhere('fatherName', 'LIKE', "%{$search}%")
                    ->paginate($per_page);
            }
            $tag = true;
        }
        return view('auth.admin.doctors', [
            'doctors' => $doctors,
            'per_page' => $per_page,
            'tag' => $tag,
            // 'getAll' => $getAll,
        ]);
    }

    public function showAddForm()
    {
        $departments = Department::all();
        return view('auth.admin.cerate_doctor', [
            'departments' => $departments
        ]);
    }

    public function store(Request $request)
    {
        // return response($request->all());
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'fatherName' => 'required|string',
            'lastName' => 'required|string',
            'userName' => 'string|required|min:6|unique:medical_people',
            'password' => 'confirmed|required',
            'phoneNumber' => 'string|required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $doctor = MedicalPerson::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'fatherName' => $request->fatherName,
            'department_id' => $request->department,
            'admin_id' => auth()->user()->id,
            'userName' => $request->userName,
            'phoneNumber' => $request->phoneNumber,
            'aboutYou' => $request->about_you,
            'password' => $request->password,
            'type' => 'doctor',
        ]);

        return redirect(route('admin.doctors'))
            ->with('message', 'Doctor Added Successfully');
    }

    function action(Request $request)
    {
        $data = $request->all();

        $query = $data['term'];

        $filter_data = MedicalPerson::select('firstName')
            ->where('firstName', 'LIKE', '%' . $query . '%')
            ->get();
        return response()->json($filter_data);
    }

    public function getEditForm($doctor_id)
    {
        $doctor_id = Crypt::decrypt($doctor_id);
        $departments = Department::all();
        $doctor = MedicalPerson::find($doctor_id);
        return view('auth.admin.edit_doctor', [
            'doctor' => $doctor,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request)
    {
        // return $request->all();
        $request->validate([
            'doctor_id' => 'required',
            'firstName' => 'required|string',
            'fatherName' => 'required|string',
            'lastName' => 'required|string',
            'userName' => [
                'required',
                'string',
                'min:5',
                Rule::unique('medical_people')->ignore($request->doctor_id),
            ],
            'password' => 'confirmed|required',
            'phoneNumber' => 'string|required',
            'isContracted' => 'required',
        ]);

        $doctor = MedicalPerson::find($request->doctor_id);

        $doctor->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'fatherName' => $request->fatherName,
            'department_id' => $request->department,
            'admin_id' => auth()->user()->id,
            'userName' => $request->userName,
            'phoneNumber' => $request->phoneNumber,
            'aboutYou' => $request->aboutYou,
            'password' => $request->password,
            'isContracted' => $request->isContracted,
        ]);

        return redirect()->route('admin.doctors')->with('success', 'Doctor has been updated successfully');
    }

    public function search()
    {
        $per_page = request()->per_page ?? 10;
        $searchs = explode(" ", request()->search);
        foreach ($searchs as $search) {
            $doctors = MedicalPerson::sortable()
                ->where('type', 'doctor')
                ->where('firstName', 'LIKE', "%{$search}%")
                ->orwhere('lastName', 'LIKE', "%{$search}%")
                ->orwhere('fatherName', 'LIKE', "%{$search}%")
                ->paginate($per_page);
        }

        return view('auth.admin.doctors', [
            'doctors' => $doctors,
            'per_page' => $per_page
        ]);
    }
}