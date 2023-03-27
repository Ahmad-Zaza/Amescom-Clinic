<?php

namespace App\Http\Controllers\RadTech;

use App\Http\Controllers\Controller;
use App\Models\Radiograph;
use App\Models\Visiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RadiographAnalysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }

    public function getMyRadiographAnalyses()
    {
        $per_page = request()->per_page ?? 10;
        $radiographAnalysis_id = auth()->user()->id;
        $radiographAnalyses = Radiograph::sortable()->where('medical_person_id', $radiographAnalysis_id)
            ->paginate($per_page);
        return view('auth.RadTech.MyRadiographAnalyses', [
            'per_page' => $per_page,
            'radiographAnalyses' => $radiographAnalyses,
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

        $radiographAnalysis = Radiograph::create([
            'content' => $request->content,
            'visiting_id' => $request->visiting_id,
            'medical_person_id' => Auth::guard('medical_person')->user()->id,
            'patient_id' => $patient_id,
        ]);

        if ($request->hasFile('photos')) {


            $photos = $radiographAnalysis->addMultipleMediaFromRequest(['photos'])
                ->each(function ($photo) {
                    $photo
                        // ->addMediaConversion('thumb')
                        // ->width(368)
                        // ->height(232)
                        // ->sharpen(10)
                        ->ToMediaCollection('radiographAnalysis');
                });
        }
        if ($radiographAnalysis) {
            return \redirect()->route('radiograph-technician.dashboard')->with('success', 'You Added radiograph Analysis successfully');
        } else {
            return \redirect()->back()->with('fail', 'Some Thing went wrong !!');
        }
    }

    public function getEditForm($radiographAnalysis_id)
    {
        $radiographAnalysis_id = Crypt::decrypt($radiographAnalysis_id);

        $radiographAnalysis = Radiograph::find($radiographAnalysis_id);
        $photos = $radiographAnalysis->getMedia('radiographAnalysis');

        return view('auth.RadTech.Edit-radiographAnalysis', [
            'radiographAnalysis' => $radiographAnalysis,
            'photos' => $photos,
        ]);
    }

    public function update(Request $request)
    {
        // return $request->all();
        $request->validate([
            'content' => 'required|string|',
            'radiographAnalysis_id' => 'required',
        ]);

        $radiographAnalysis = Radiograph::find($request->radiographAnalysis_id);

        $radiographAnalysis->update([
            'content' => $request->content,
        ]);
        if ($request->hasFile('photos')) {
            $photos = $radiographAnalysis->addMultipleMediaFromRequest(['photos'])
                ->each(function ($photo) {
                    $photo
                        // ->addMediaConversion('thumb')
                        // ->width(368)
                        // ->height(232)
                        // ->sharpen(10)
                        ->ToMediaCollection('radiographAnalysis');
                });
        }
        return redirect()->back()->with('success', 'The radiograph Analysis has been updated successfully');
    }

    public function deletePhoto(Request $request, $photo_id)
    {
        $radiographAnalysis = Radiograph::find($request->radiographAnalysis_id);
        $photos = $radiographAnalysis->getMedia('radiographAnalysis');
        // return $request->photo;
        foreach ($photos as $photo) {
            if ($photo_id === $photo->uuid) {
                // return $photo->getUrl();
                $photo->delete();
            }
        }

        return redirect()->back()->with('success', 'Photo has been deleted successfully');
    }


    public function getSingleradiographAnalysis($radiographAnalysis_id)
    {
        $radiographAnalysis_id = Crypt::decrypt($radiographAnalysis_id);

        $radiographAnalysis = Radiograph::find($radiographAnalysis_id);

        $photos = $radiographAnalysis->getMedia('radiographAnalysis');

        return view('auth.RadTech.radiographAnalysis', [
            'radiographAnalysis' => $radiographAnalysis,
            'photos' => $photos,
        ]);
    }
}