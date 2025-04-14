<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Search\TemplateSearchService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct(public TemplateSearchService $searchService) {}

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {

        return response()->json(
            $this->searchService
                ->request($request)
                ->campaign($campaign)
                ->entityType($entityType)
                ->search()
        );
    }

    /**
     * Live Search
     */
    public function months(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');

        return response()->json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->monthList()
        );
    }
}
