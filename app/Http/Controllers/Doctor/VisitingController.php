<?php

namespace App\Http\Controllers\Doctor;

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

    public function getCurrentVisitings($doctor_id, $department_id)
    {
        $per_page = request()->per_page ?? 10;
        $department_id = Crypt::decrypt($department_id);
        $doctor_id = Crypt::decrypt($doctor_id);
        $visits = Visiting::sortable()->where('department_id', $department_id)
            ->where('status', 'new')
            ->with('patient')
            ->paginate($per_page);

        return view('auth.doctor.department_requests', [
            'visits' => $visits,
            'per_page' => $per_page,
        ]);
    }
}