<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\CampaignSearchService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function __construct(protected CampaignSearchService $searchService) {}

    public function members(Request $request, Campaign $campaign)
    {
        $this->authorize('search', $campaign);

        return response()->json(
            $this->searchService
                ->campaign($campaign)
                ->members(
                    $request->get('q')
                )
        );
    }

    public function roles(Request $request, Campaign $campaign)
    {
        $this->authorize('search', $campaign);

        return response()->json(
            $this->searchService
                ->campaign($campaign)
                ->roles(
                    $request->get('q')
                )
        );
    }
}
