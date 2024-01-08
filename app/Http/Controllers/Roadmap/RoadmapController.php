<?php

namespace App\Http\Controllers\Roadmap;

use App\Enums\FeatureStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeature;
use App\Models\Feature;
use App\Models\FeatureCategory;

class RoadmapController extends Controller
{
    public function index()
    {
        $categories = FeatureCategory::with(['features', 'progress'])->get();
        $ideas = Feature::approved()->paginate();
        return view('roadmap.index')
            ->with('categories', $categories)
            ->with('ideas', $ideas)
        ;
    }

    public function store(StoreFeature $request)
    {
        $feat = new Feature();
        $feat->created_by = $request->user()->id;
        $feat->name = $request->get('name');
        $feat->description = $request->get('description');
        $feat->status_id = FeatureStatus::Draft;
        $feat->save();

        return redirect()->route('roadmap');
    }
}
