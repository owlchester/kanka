<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\CampaignSearchService;

class CampaignSearchController extends Controller
{
    protected CampaignSearchService $search;

    /**
     * CampaignSearchController constructor.
     * @param CampaignSearchService $searchService
     */
    public function __construct(CampaignSearchService $searchService)
    {
        $this->search = $searchService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function members(Campaign $campaign)
    {
        $this->authorize('search', $campaign);

        return response()->json(
            $this->search
                ->campaign($campaign)
                ->members(request()->get('q'))
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles(Campaign $campaign)
    {
        $this->authorize('search', $campaign);

        return response()->json(
            $this->search
                ->campaign($campaign)
                ->roles(request()->get('q'))
        );
    }
}
