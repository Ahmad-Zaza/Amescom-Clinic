<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Visiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class VisitingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }
    public function getCurrentVisitings($department_id)
    {
        $per_page = request()->per_page ?? 10;
        $department_id = Crypt::decrypt($department_id);
        $visits = Visiting::sortable()->where('department_id', $department_id)
            ->where('status', 'new')
            ->with('patient')
            ->paginate($per_page);

        return view('auth.LabTech.department_requests', [
            'visits' => $visits,
            'per_page' => $per_page,
        ]);
    }


    public function closeState($visiting_id)
    {
        $visiting_id = Crypt::decrypt($visiting_id);
        $visiting = Visiting::find($visiting_id);

        $visiting->update([
            'status' => 'done',
        ]);

        return redirect()->back()->with('success', 'Patient has been logged out successfully');
    }
}