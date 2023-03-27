<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Visiting;
use Illuminate\Http\Request;

class VisitingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:reception');
    }

    public function getVisitingPage()
    {
        $per_page = request()->per_page ?? 10;
        $visits = Visiting::sortable()->with('department')->with('patient')->paginate($per_page);

        return view('auth.receptionist.visits', [
            'visits' => $visits,
            'per_page' => $per_page,
        ]);
    }
}