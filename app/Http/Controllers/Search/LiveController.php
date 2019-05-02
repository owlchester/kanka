<?php

namespace App\Http\Controllers\Search;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Response;

class LiveController extends Controller
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
     * Live Search
     */
    public function index(Request $request)
    {
        $term = trim($request->q);
        $type = trim($request->type);
        $campaign = CampaignLocalization::getCampaign();

        return Response::json(
            $this->search
                ->term($term)
                ->type($type)
                ->campaign($campaign)
                ->full()
                ->find()
        );
    }

    /**
     * Filter on entities which have reminders (entity_events)
     * @param Request $request
     * @return mixed
     */
    public function reminderEntities(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        return Response::json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->exclude(['calendars', 'tags'])
                ->find()
        );
    }

    /**
     * Filter on entities which have relations
     * @param Request $request
     * @return mixed
     */
    public function relationEntities(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        return Response::json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->exclude(['menu_link'])
                ->find()
        );
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
