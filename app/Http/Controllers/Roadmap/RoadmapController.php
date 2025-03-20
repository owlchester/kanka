<?php

namespace App\Http\Controllers\Roadmap;

use App\Http\Controllers\Controller;

class RoadmapController extends Controller
{
    public function index()
    {
        return view('roadmap.index');
    }
}
