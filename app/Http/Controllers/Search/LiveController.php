<?php

namespace App\Http\Controllers\Search;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Tag;
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
        $exclude = trim($request->exclude);
        $campaign = CampaignLocalization::getCampaign();
        $new = request()->has('new');

        return Response::json(
            $this->search
                ->term($term)
                ->type($type)
                ->campaign($campaign)
                ->new($new)
                ->full()
                ->excludeIds($exclude)
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
                ->exclude([
                    config('entities.ids.calendar'),
                    config('entities.ids.tag'),
                    config('entities.ids.map'),
                    config('entities.ids.timeline')
                ])
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
                ->exclude([config('entities.ids.menu_link')])
                ->find()
        );
    }


    /**
     * Filter on entities which have multiple tags
     * @param Request $request
     * @return mixed
     */
    public function tagChildren(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        $exclude = [];
        if ($request->has('exclude')) {
            /** @var Tag $tag */
            $tag = Tag::findOrFail($request->get('exclude'));
            $exclude = $tag->entities->pluck('id')->toArray();
        }

        return Response::json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->exclude([config('entities.ids.tag')])
                ->excludeIds($exclude)
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
                ->only([config('entities.ids.calendar')])
                ->find()
        );
    }
}
