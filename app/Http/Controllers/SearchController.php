<?php

namespace App\Http\Controllers;

use App\Character;
use App\Family;
use App\Item;
use App\Location;
use App\Models\Event;
use App\Models\Quest;
use App\Note;
use App\Organisation;
use App\Services\CampaignService;
use App\Services\EntityService;
use App\Services\LinkerService;
use Illuminate\Http\Request;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CampaignService $campaignService, EntityService $entityService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->entity = $entityService;
    }

    public function search(Request $request)
    {
        $this->campaign = new CampaignService();

        $term = trim($request->q);
        $elements = [];
        $results = [];
        $active = '';

        foreach ($this->entity->entities() as $element => $class) {
            if ($this->campaign->enabled($element)) {
                $model = new $class;
                $results[$element] = $model->where('name', 'like', "%$term%")->limit(5)->get();
                $active = empty($active) ? $element : $active;
            }
        }

        return view('search.index', compact(
            'term',
            'results',
            'active'
        ));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locations(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Location::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function characters(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Character::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function families(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Family::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function notes(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Note::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function organisations(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Organisation::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function events(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Event::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function quests(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Quest::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }
}
