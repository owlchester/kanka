<?php


namespace App\Http\Controllers\Search;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Services\Search\CampaignSearchService;

class CampaignSearchController extends Controller
{
    /**
     * @var CampaignSearchService
     */
    protected $search;

    /**
     * CampaignSearchController constructor.
     * @param CampaignSearchService $searchService
     */
    public function __construct(CampaignSearchService $searchService)
    {
        $this->search = $searchService;
        $campaign = CampaignLocalization::getCampaign();
        if ($campaign) {
            $this->search->campaign($campaign);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function members()
    {
        $this->authorize('search', CampaignLocalization::getCampaign());

        return response()->json(
            $this->search->members(
                request()->get('q')
            )
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles()
    {
        $this->authorize('search', CampaignLocalization::getCampaign());

        return response()->json(
            $this->search->roles(
                request()->get('q')
            )
        );
    }
}
