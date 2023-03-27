<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Visiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function showPrescriptionForm($visiting_id)
    {
        $visiting_id = Crypt::decrypt($visiting_id);
        return view('auth.doctor.create_prescriptoin', [
            'visiting_id' => $visiting_id,
        ]);
    }

    public function store(Request $request)
    {
        $count = 0;
        // return $request->all();
        $request->validate([
            'content' => 'required|string|',
            'visiting_id' => 'required'
        ]);

        $visiting = Visiting::find($request->visiting_id);
        $patient_id = $visiting->patient->id;
        // return $visiting->patient->id;

        $prescription = Prescription::create([
            'content' => $request->content,
            'visiting_id' => $request->visiting_id,
            'medical_person_id' => Auth::guard('medical_person')->user()->id,
            'patient_id' => $patient_id,
        ]);

        if ($request->hasFile('photos')) {


            $photos = $prescription->addMultipleMediaFromRequest(['photos'])
                ->each(function ($photo) {
                    $photo
                        // ->addMediaConversion('thumb')
                        // ->width(368)
                        // ->height(232)
                        // ->sharpen(10)
                        ->ToMediaCollection('prescription');
                });
        }
        if ($prescription) {
            return \redirect()->route('doctor.dashboard')
                ->with('success', 'You Added Prescription successfully');
        } else {
            return \redirect()->back()->with('fail', 'Some Thing went wrong !!');
        }
    }



    public function getAllPatientPrescriptions($patient_id)
    {
        $per_page = request()->per_page ?? 10;
        $patient_id = Crypt::decrypt($patient_id);

        $patient = Patient::find($patient_id);
        $prescriptions = Prescription::sortable()->where('patient_id', $patient_id)
            ->paginate($per_page);
        // $prescriptions = $patient->prescriptions()::sortable()->paginate($per_page);

        return view('auth.doctor.patient-prescriptions', [
            'prescriptions' => $prescriptions,
            'per_page' => $per_page,
        ]);
    }

    public function getSinglePrescription($prescription_id)
    {
        $prescription_id =  Crypt::decrypt($prescription_id);
        $medicalFolder = Prescription::find($prescription_id);
        $photos = $medicalFolder->getMedia('prescription');
        return view('auth.doctor.medical-folder', [
            'medicalFolder' => $medicalFolder,
            'photos' => $photos,
        ]);
    }

    public function getEditForm($prescription_id)
    {
        $prescription_id = Crypt::decrypt($prescription_id);

        $prescription = Prescription::find($prescription_id);
        $photos = $prescription->getMedia('prescription');

        return view('auth.doctor.Edit-prescription', [
            'prescription' => $prescription,
            'photos' => $photos,
        ]);
    }

    public function update(Request $request)
    {
        // return $request->all();
        $request->validate([
            'content' => 'required|string|',
            'prescription_id' => 'required',
        ]);

        $prescription = Prescription::find($request->prescription_id);

        $prescription->update([
            'content' => $request->content,
        ]);
        if ($request->hasFile('photos')) {
            $photos = $prescription->addMultipleMediaFromRequest(['photos'])
                ->each(function ($photo) {
                    $photo
                        // ->addMediaConversion('thumb')
                        // ->width(368)
                        // ->height(232)
                        // ->sharpen(10)
                        ->ToMediaCollection('prescription');
                });
        }
        return redirect()->back()->with('success', 'The prescription has been updated successfully');
    }

    public function getMyPrescriptions()
    {
        $per_page = request()->per_page ?? 10;
        $doctor_id = auth()->user()->id;
        $prescriptions = Prescription::sortable()->where('medical_person_id', $doctor_id)
            ->paginate($per_page);
        return view('auth.doctor.my-prescriptions', [
            'per_page' => $per_page,
            'prescriptions' => $prescriptions,
        ]);
    }

    public function deletePhoto(Request $request)
    {
        // return 'am here';
        $counter = 0;
        $prescription = Prescription::find($request->prescription_id);
        $photos = $prescription->getMedia('prescription');
        foreach ($photos as $photo) {
            if ($request->photo === $photo->getUrl()) {
                // return $photo->getPath();
                $photos[$counter]->delete();
            }
            $counter++;
        }

        return redirect()->back()->with('success', 'Photo has been deleted successfully');
    }
}