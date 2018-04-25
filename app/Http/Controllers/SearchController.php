<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Family;
use App\Models\Item;
use App\Models\Location;
use App\Models\Event;
use App\Models\Quest;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Section;
use App\Services\CampaignService;
use App\Services\EntityService;
use App\Services\LinkerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FilterService;
use Response;

class SearchController extends Controller
{
    /**
     * @var CampaignService
     */
    protected $campaign;

    /**
     * @var EntityService
     */
    protected $entity;

    /**
     * @var FilterService
     */
    protected $filterService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CampaignService $campaignService, EntityService $entityService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->entity = $entityService;
        $this->campaign = $campaignService;


        $this->filterService = new FilterService();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $term = trim($request->q);
        $results = [];
        $active = '';
        $filterService = $this->filterService;

        foreach ($this->entity->entities() as $element => $class) {
            if ($this->campaign->enabled($element)) {
                $model = new $class;
                $results[$element] = $model->acl(Auth::user())->search($term)->limit(5)->get();
                $active = count($results[$element]) > 0 && empty($active) ? $element : $active;
            }
        }

        return view('search.index', compact(
            'term',
            'results',
            'active',
            'filterService'
        ));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function entities(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name . ' (' . trans('entities.' . $model->type) . ')'];
        }

        return Response::json($formatted);
    }

    /**
     * Mentions
     */
    public function mentions(Request $request)
    {
        $term = trim($request->q);

        // Figure out what kind of entities we want.

        if (empty($term)) {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = [
                'id' => $model->id,
                'fullname' => $model->name,
                'name' => $model->name . ' (' . trans('entities.' . $model->type) . ')',
                'tooltip' => $model->tooltip(),
                'url' => route($model->pluralType() . '.show', $model->entity_id
                )];
        }

        return Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locations(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Location::class);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function characters(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Character::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function families(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Family::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function organisations(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Organisation::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function events(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Event::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function quests(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Quest::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sections(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Section::class);
    }

    /**
     * Search for month names
     * @param Request $request
     * @return mixed
     */
    public function months(Request $request)
    {
        $term = trim($request->q);
        $formatted = [];

        // Load up the calendars of a campaign to get the month names
        $calendars = Calendar::all();
        foreach ($calendars as $calendar) {
            $months = $calendar->months();

            foreach ($months as $month) {
                if ((!empty($term) && strpos($month['name'], $term) !== false) || empty($term)) {
                    $formatted[] = [
                        'fullname' => $month['name'],
                        'name' => $month['name'] . ' (' . $calendar->name . ')',
                    ];
                }
            }
        }

        return Response::json($formatted);
    }

    /**
     * Get a list of enabled entity types for the campaign to filter on the entities table
     * @return array
     */
    protected function enabledEntityTypes()
    {
        $entityTypes = [];
        foreach ($this->entity->entities() as $element => $class) {
            if ($this->campaign->enabled($element)) {
                $entityTypes[] = $this->entity->singular($element);
            }
        }
        return $entityTypes;
    }

    /**
     * Build the search results
     * @param $term
     * @param $class
     * @return mixed
     */
    protected function buildSearchResults($term, $class)
    {
        $modelClass = new $class;
        if (empty($term)) {
            $models = $modelClass->acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = $modelClass->acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return Response::json($formatted);
    }
}
