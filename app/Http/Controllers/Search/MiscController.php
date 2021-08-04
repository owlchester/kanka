<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Entity;
use App\Models\MapMarker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;

class MiscController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locations(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Location::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function characters(Request $request)
    {
        if ($request->has('with_family')) {
            return $this->familyCharacters($request);
        }
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Character::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function familyCharacters(Request $request)
    {
        $term = trim($request->q);

        /** @var Builder $modelClass */
        $modelClass = new Character();
        if (empty($term)) {
            $models = $modelClass
                ->with('family')
                ->limit(10)
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            $models = $modelClass
                ->with('family')
                ->where('name', 'like', "%$term%")
                ->limit(10)
                ->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->name . (!empty($model->family) ? ' (' . $model->family->name . ')' : null)
            ];
            $formatted[] = $format;
        }

        return Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function families(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Family::class, $exclude);
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
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Organisation::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function events(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Event::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function quests(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Quest::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function calendars(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Calendar::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function timelines(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Timeline::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function tags(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Tag::class, $exclude);
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
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Race::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function maps(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Map::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function markers(Request $request)
    {
        $term = trim($request->q);
        //parent map_id allowed for the marker (limits search to the markers of the map only)
        $include = $request->has('include') ? [$request->get('include')] : [];

        //marker must be in given map
        $modelClass = MapMarker::whereIn('map_id', $include);

        //Search text
        if (!empty($term)) {
            if (Str::startsWith($term, '=')) {
                $modelClass->where('name', ltrim($term, '='));
            } else {
                $modelClass->where('name2', 'like', "%$term%");
            }
        } else {
            $modelClass->orderBy('updated_at', 'desc');
        }

        //execute query
        $models = $modelClass->limit(10)
                    ->get();

        //format results for frontend select
        $formatted = [];
        /** @var MapMarker $model */
        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->markerTitle()
            ];

            $formatted[] = $format;
        }

        return Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function notes(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Note::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function journals(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Journal::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function abilities(Request $request)
    {
        $term = trim($request->get('q', null));
        $exclude = [];
        if ($request->has('exclude-entity')) {
            /** @var Entity $entity */
            $entity = Entity::findOrFail($request->get('exclude-entity'));
            $exclude = $entity->abilities->pluck('ability_id')->toArray();
        } elseif ($request->has('exclude')) {
            $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        }
        return $this->buildSearchResults($term, \App\Models\Ability::class, $exclude);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function attributeTemplates(Request $request)
    {
        $term = trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\AttributeTemplate::class, $exclude);
    }

    /**
     * Build the search results
     * @param string $term
     * @param string $class
     * @param array $excludes
     * @return mixed
     */
    protected function buildSearchResults($term, $class, array $excludes = [])
    {
        /** @var Builder $modelClass */
        $modelClass = new $class;
        if (empty($term)) {
            $models = $modelClass->whereNotIn('id', $excludes)
                ->limit(10)
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            $models = $modelClass->whereNotIn('id', $excludes);
            // Exact match
            if (Str::startsWith($term, '=')) {
                $models->where('name', ltrim($term, '='));
            } else {
                $models->where('name', 'like', "%$term%");
            }
            $models = $models
                ->limit(10)
                ->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->name
            ];
            if ($class === 'App\Models\Tag' && $model->hasColour()) {
                $format['colour'] = $model->colourClass();
            }

            $formatted[] = $format;
        }

        return Response::json($formatted);
    }
}
