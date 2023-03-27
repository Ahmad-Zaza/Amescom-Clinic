<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MedicalPerson;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RadiographTechniciansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getRadiographTechPage()
    {
        $searchs = explode(" ", request()->search);
        $per_page = request()->per_pgae ?? 10;
        $search = request()->search;
        if (!$search) {
            $radiographs = MedicalPerson::sortable()->where('type', 'radiograph')
                ->paginate($per_page);
            $tag = false;
        } else {
            $radiographs = MedicalPerson::sortable()->where('type', 'radiograph')
                ->where('firstName', 'LIKE', "%{$search}%")
                ->orwhere('lastName', 'LIKE', "%{$search}%")
                ->orwhere('fatherName', 'LIKE', "%{$search}%")
                ->paginate($per_page);
            $tag = true;
        }
        return view('auth.admin.radiographTechnicians', [
            'radiographs' => $radiographs,
            'per_page' => $per_page,
            'tag' => $tag,
        ]);
    }

    public function showAddForm()
    {
        $departments = Department::all();
        return view('auth.admin.create_RadTech', [
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

        $RadTech = MedicalPerson::create([
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

        return redirect(route('admin.radiographs'))
            ->with('message', 'Doctor Added Successfully');
    }

    public function getEditForm($radTech_id)
    {
        $radTech_id = Crypt::decrypt($radTech_id);
        $departments = Department::all();
        $radTech = MedicalPerson::find($radTech_id);
        return view('auth.admin.edit_RadTech', [
            'radTech' => $radTech,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'radTech_id' => 'required',
            'firstName' => 'required|string',
            'fatherName' => 'required|string',
            'lastName' => 'required|string',
            'userName' => [
                'required',
                'string',
                'min:5',
                Rule::unique('medical_people')->ignore($request->radTech_id),
            ],
            'password' => 'confirmed|required',
            'phoneNumber' => 'string|required',
            'isContracted' => 'required',
        ]);

        $radTech = MedicalPerson::find($request->radTech_id);

        $radTech->update([
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

        return redirect()->route('admin.radiographs')->with('success', 'Radiograph Technicians Has been updated successfully');
    }
}