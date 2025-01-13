<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Gallery\SetupService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected SetupService $service;

    public function __construct(SetupService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $term = mb_trim($request->get('term'));

        return response()->json(
            $this->service
                ->user($request->user())
                ->campaign($campaign)
                ->term($term)
                ->filters($request->only('unused'))
                ->search()
        );
    }
}
