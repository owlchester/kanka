<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Entity;
use App\Models\Family;
use App\Models\Item;
use App\Models\Location;
use App\Models\Event;
use App\Models\Quest;
use App\Models\Note;
use App\Models\Organisation;
use App\Services\CampaignService;
use App\Services\EntityService;
use App\Services\LinkerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                $results[$element] = $model->acl(Auth::user())->search($term)->limit(5)->get();
                $active = count($results[$element]) > 0 && empty($active) ? $element : $active;
            }
        }

        return view('search.index', compact(
            'term',
            'results',
            'active'
        ));
    }

    public function entities(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            $models = Entity::limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name . ' (' . trans('entities.' . $model->type) . ')'];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locations(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            $models = Location::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Location::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }

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
            $models = Character::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Character::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
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
            $models = Family::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Family::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
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
            $models = Note::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Note::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
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
            $models = Organisation::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Organisation::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
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
            $models = Event::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Event::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
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
            $models = Quest::acl(Auth::user())->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Quest::acl(Auth::user())->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * Mentions
     */
    public function mentions(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            $models = Entity::limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = Entity::where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = [
                'id' => $model->id,
                'fullname' => $model->name,
                'name' => $model->name . ' (' . trans('entities.' . $model->type) . ')',
                'url' => route($model->pluralType() . '.show', $model->entity_id
                )];
        }

        return \Response::json($formatted);
    }
}
