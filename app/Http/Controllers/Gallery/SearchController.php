<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Gallery\SetupService;

class SearchController extends Controller
{
    protected SetupService $service;

    public function __construct(SetupService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Campaign $campaign, $term)
    {
        $this->authorize('gallery', $campaign);

        $term = trim($term);

        return response()->json(
            $this->service
                ->user(auth()->user())
                ->campaign($campaign)
                ->term($term)
                ->search()
        );
    }
}
