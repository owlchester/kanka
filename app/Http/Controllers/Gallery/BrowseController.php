<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Gallery\BrowseService;
use Illuminate\Http\Request;

class BrowseController extends Controller
{

    protected BrowseService $service;

    public function __construct(BrowseService $browseService)
    {
        $this->service = $browseService;
    }
    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('galleryBrowse', $campaign);

        return response()->json(
            $this->service
            ->campaign($campaign)
            ->folder($request->get('folder'))
            ->term($request->get('term'))
            ->images()
        );
    }
}
