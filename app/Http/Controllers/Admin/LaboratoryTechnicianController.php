<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MedicalPerson;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class LaboratoryTechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getLabTechPage()
    {
        $searchs = explode(" ", request()->search);
        $per_page = request()->per_page ?? 10;
        $search = request()->search;
        if (!$search) {
            $technicians = MedicalPerson::sortable()->where('type', 'analysis')
                ->paginate($per_page);
            $tag = false;
        } else {
            foreach ($searchs as $search) {
                $technicians = MedicalPerson::sortable()->where('type', 'analysis')
                    ->where('firstName', 'LIKE', "%{$search}%")
                    ->orwhere('lastName', 'LIKE', "%{$search}%")
                    ->orwhere('fatherName', 'LIKE', "%{$search}%")
                    ->paginate($per_page);
            }
            $tag = true;
        }
        return view('auth.admin.labTechnicians', [
            'technicians' => $technicians,
            'per_page' => $per_page,
            'tag' => $tag,
        ]);
    }

    public function showAddForm()
    {
        $departments = Department::all();
        return view('auth.admin.create_LabTech', [
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

        $LabTech = MedicalPerson::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'fatherName' => $request->fatherName,
            'department_id' => $request->department,
            'admin_id' => auth()->user()->id,
            'userName' => $request->userName,
            'phoneNumber' => $request->phoneNumber,
            'about_you' => $request->about_you,
            'password' => $request->password,
            'type' => 'analysis',
        ]);

        return redirect(route('admin.labTechs'))
            ->with('message', 'Laboratory Technician Added Successfully');
    }

    public function getEditForm($labTech_id)
    {
        $labTech_id = Crypt::decrypt($labTech_id);
        $departments = Department::all();
        $labTech = MedicalPerson::find($labTech_id);
        return view('auth.admin.edit_LabTech', [
            'labTech' => $labTech,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'labTech_id' => 'required',
            'firstName' => 'required|string',
            'fatherName' => 'required|string',
            'lastName' => 'required|string',
            'userName' => [
                'required',
                'string',
                'min:5',
                Rule::unique('medical_people')->ignore($request->labTech_id),
            ],
            'password' => 'confirmed|required',
            'phoneNumber' => 'string|required',
            'isContracted' => 'required',
        ]);

        $labTech = MedicalPerson::find($request->labTech_id);

        $labTech->update([
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

        return redirect()->route('admin.labTechs')->with('success', 'Laboratory Technicians Has been updated successfully');
    }
}