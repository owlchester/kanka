<?php

namespace App\Http\Controllers\Roadmap;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\FeatureCategory;

class RoadmapController extends Controller
{
    public function index()
    {
        $categories = FeatureCategory::with(['features', 'next', 'now', 'later', 'next.uservote', 'now.uservote', 'later.uservote'])->get();

        return view('roadmap.index')
            ->with('categories', $categories)
        ;
    }

}
