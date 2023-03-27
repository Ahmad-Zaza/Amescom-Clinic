<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visiting;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;

class VisitingController extends Controller
{
    use QueryTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getVisitingPage()
    {
        $per_page = request()->per_page ?? 10;
        $visits = Visiting::sortable()->with('department')->with('patient')
            ->paginate(request()->per_page ?? 10);

        return view('auth.admin.visits', [
            'visits' => $visits,
            'per_page' => $per_page,
        ]);
    }
}