<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Search\LiveSearchService;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __construct(protected LiveSearchService $service)
    {
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        return response()->json(
            $this->service
                ->campaign($campaign)
                ->request($request)
                ->entityType($entityType)
                ->search()
        );
    }
}
