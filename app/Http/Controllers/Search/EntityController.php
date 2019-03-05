<?php

namespace App\Http\Controllers\Search;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Response;

class EntityController extends Controller
{
    /**
     * @var SearchService
     */
    protected $search;

    /**
     * LiveController constructor.
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->search = $searchService;
    }

    /**
     * Only find calendar entities
     * @param Request $request
     * @return mixed
     */
    public function calendars(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        return Response::json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->only(['calendars'])
                ->find()
        );
    }
}
