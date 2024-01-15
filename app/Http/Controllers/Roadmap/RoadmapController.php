<?php

namespace App\Http\Controllers\Roadmap;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\FeatureCategory;

class RoadmapController extends Controller
{
    public function index()
    {
        return view('roadmap.index');
    }

}
