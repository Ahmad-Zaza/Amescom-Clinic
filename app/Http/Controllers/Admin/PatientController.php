<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getPatientsPage()
    {
        $per_page = request()->per_page ?? 10;
        $patients = Patient::sortable()
            ->paginate(request()->per_page ?? $per_page);

        return view('auth.admin.patients', [
            // 'patients' => $this->doPagination(request()->all(), $patients),
            'patients' => $patients,
            'per_page' => $per_page,
        ]);
    }
}