<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Services\Search\MapGroupSearchService;
use Illuminate\Http\Request;

class MapGroupController extends Controller
{
    public function __construct(protected MapGroupSearchService $service) {}

    public function index(Request $request, Campaign $campaign, Map $map)
    {
        return response()->json(
            $this->service
                ->campaign($campaign)
                ->map($map)
                ->request($request)
                ->search()
        );
    }
}
