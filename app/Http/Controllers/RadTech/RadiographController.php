<?php

namespace App\Http\Controllers\RadTech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RadiographController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medical_person');
    }
}