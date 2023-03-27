<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\MedicalAnalysis;
use App\Models\Visiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MedicalAnalysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function showMedicalAnalysisForm($visiting_id)
    {
        $visiting_id = Crypt::decrypt($visiting_id);
        return view('auth.LabTech.create_medical_analysis', [
            'visiting_id' => $visiting_id,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|',
            'visiting_id' => 'required'
        ]);

        $visiting = Visiting::find($request->visiting_id);
        $patient_id = $visiting->patient->id;
        // return $visiting->patient->id;

        $medicalAnalysis = MedicalAnalysis::create([
            'content' => $request->content,
            'visiting_id' => $request->visiting_id,
            'medical_person_id' => Auth::guard('medical_person')->user()->id,
            'patient_id' => $patient_id,
        ]);

        if ($request->hasFile('photos')) {


            $photos = $medicalAnalysis->addMultipleMediaFromRequest(['photos'])
                ->each(function ($photo) {
                    $photo
                        // ->addMediaConversion('thumb')
                        // ->width(368)
                        // ->height(232)
                        // ->sharpen(10)
                        ->ToMediaCollection('medicalAnalysis');
                });
        }
        if ($medicalAnalysis) {
            return \redirect()->route('laboratory-technician.dashboard')->with('success', 'You Added Prescription successfully');
        } else {
            return \redirect()->back()->with('fail', 'Some Thing went wrong !!');
        }
    }

    public function getEditForm($medicalAnalysis_id)
    {
        $medicalAnalysis_id = Crypt::decrypt($medicalAnalysis_id);

        $medicalAnalysis = MedicalAnalysis::find($medicalAnalysis_id);
        $photos = $medicalAnalysis->getMedia('medicalAnalysis');

        return view('auth.LabTech.Edit-medicalAnalysis', [
            'medicalAnalysis' => $medicalAnalysis,
            'photos' => $photos,
        ]);
    }

    public function update(Request $request)
    {
        // return $request->all();
        $request->validate([
            'content' => 'required|string|',
            'medicalAnalysis_id' => 'required',
        ]);

        $medicalAnalysis = MedicalAnalysis::find($request->medicalAnalysis_id);

        $medicalAnalysis->update([
            'content' => $request->content,
        ]);
        if ($request->hasFile('photos')) {
            $photos = $medicalAnalysis->addMultipleMediaFromRequest(['photos'])
                ->each(function ($photo) {
                    $photo
                        ->ToMediaCollection('medicalAnalysis');
                });
        }
        return redirect()->back()->with('success', 'The medical Analysis has been updated successfully');
    }

    public function deletePhoto(Request $request, $photo_id)
    {
        $medicalAnalysis = MedicalAnalysis::find($request->medicalAnalysis_id);
        $photos = $medicalAnalysis->getMedia('medicalAnalysis');
        foreach ($photos as $photo) {
            if ($photo_id === $photo->uuid) {
                $photo->delete();
            }
        }

        return redirect()->back()->with('success', 'Photo has been deleted successfully');
    }

    public function getSingleMedicalAnalysis($medicalAnalysis_id)
    {
        $medicalAnalysis_id = Crypt::decrypt($medicalAnalysis_id);

        $medicalAnalysis = MedicalAnalysis::find($medicalAnalysis_id);

        $photos = $medicalAnalysis->getMedia('medicalAnalysis');

        return view('auth.LabTech.medicalAnalysis', [
            'medicalAnalysis' => $medicalAnalysis,
            'photos' => $photos,
        ]);
    }
}