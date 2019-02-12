<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Models\Calendar;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\CampaignService;
use App\Services\EntityService;
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
        //$this->middleware('auth');
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
        $resultCount = 0;
        $active = '';
        $filterService = $this->filterService;
        $filters = null;
        $found = null;

        foreach ($this->entity->entities(['menu_links']) as $element => $class) {
            if ($this->campaign->enabled($element)) {
                $model = new $class;
                $results[$element] = $model->acl()->search($term)->limit(5)->get();
                $active = count($results[$element]) > 0 && empty($active) ? $element : $active;
                $resultCount += count($results[$element]);

                if (count($results[$element]) == 1) {
                    if ($found === null) {
                        $found = $results[$element][0];
                    } else {
                        $found = false;
                    }
                }
            }
        }

        // Found just one result?
        if ($resultCount == 1 && $found instanceof MiscModel) {
            return redirect()->route($found->entity->pluralType() . '.show', $found);
        }

        return view('search.index', compact(
            'filters',
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
        $campaign = CampaignLocalization::getCampaign();

        if (empty($term)) {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            // Force there to be a child! There seems to be a bug where deleted entities still have a row in the "entities" table.
            if ($model->child) {
                if (EntityPermission::canView($model, $campaign)) {
                    $formatted[] = ['id' => $model->id, 'text' => $model->name . ' (' . trans('entities.' . $model->type) . ')'];
                }
            }
        }

        return Response::json($formatted);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function entityCalendars(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        if (empty($term)) {
            $models = Entity::whereIn('type', ['calendar'])->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::whereIn('type', ['calendar'])->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            // Force there to be a child! There seems to be a bug where deleted entities still have a row in the "entities" table.
            if ($model->child) {
                if (EntityPermission::canView($model, $campaign)) {
                    $formatted[] = ['id' => $model->id, 'text' => $model->name . ' (' . trans('entities.' . $model->type) . ')'];
                }
            }
        }

        return Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function calendarEvent(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        if (empty($term)) {
            $models = Entity::whereIn('type', $this->enabledEntityTypes(['calendars', 'categories']))->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::whereIn('type', $this->enabledEntityTypes(['calendars', 'categories']))->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            // Force having a child for "ghost" entities.
            if ($model->child) {
                if (EntityPermission::canView($model, $campaign)) {
                    $formatted[] = ['id' => $model->id, 'text' => $model->name . ' (' . trans('entities.' . $model->type) . ')'];
                }
            }
        }

        return Response::json($formatted);
    }

    /**
     * Mentions
     */
    public function mentions(Request $request)
    {
        return $this->live($request);
    }

    /**
     * Live Search
     */
    public function live(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();

        // Figure out what kind of entities we want.
        if (empty($term)) {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::whereIn('type', $this->enabledEntityTypes())->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            // Force having a child for "ghost" entities.
            if ($model->child) {
                if (EntityPermission::canView($model, $campaign)) {
                    $formatted[] = [
                        'id' => $model->id,
                        'fullname' => e($model->name),
                        'image' => !empty($model->child->image) ? '<span class="entity-image-mention" style="background-image: url(\'' . $model->child->getImageUrl(true) . '\');"></span> ' : '',
                        'name' => e($model->name),
                        'type' => trans('entities.' . $model->type),
                        'tooltip' => $model->tooltip(),
                        'url' => route($model->pluralType() . '.show', $model->entity_id)
                    ];
                }
            }
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
    public function items(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Item::class);
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
    public function calendars(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Calendar::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function tags(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Tag::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function diceRolls(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\DiceRoll::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function conversations(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Conversation::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function races(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Race::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function attributeTemplates(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\AttributeTemplate::class);
    }

    /**
     * Search for month names
     * @param Request $request
     * @return mixed
     */
    public function months(Request $request)
    {
        $term = trim($request->q);
        $campaign = CampaignLocalization::getCampaign();
        $formatted = [];

        // Load up the calendars of a campaign to get the month names
        $calendars = Calendar::all();
        foreach ($calendars as $calendar) {
            if (EntityPermission::canView($calendar->entity, $campaign)) {
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
        }

        return Response::json($formatted);
    }

    /**
     * Get a list of enabled entity types for the campaign to filter on the entities table
     * @param array $except A list of entities that aren't desired
     * @return array
     */
    protected function enabledEntityTypes($except = [])
    {
        $entityTypes = [];
        foreach ($this->entity->entities() as $element => $class) {
            if (in_array($element, $except)) {
                continue;
            }
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
            $models = $modelClass->acl()->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = $modelClass->acl()->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return Response::json($formatted);
    }
}
