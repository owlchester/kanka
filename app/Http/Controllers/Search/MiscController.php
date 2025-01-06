<?php

namespace App\Http\Controllers\Search;

use App\Facades\Avatar;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    }

    /**
     */
    public function locations(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Location::class, $exclude);
    }

    /**
     */
    public function characters(Request $request, Campaign $campaign)
    {
        if ($request->has('with_family')) {
            return $this->familyCharacters($request, $campaign);
        }
        $term = mb_trim($request->q);
        return $this->buildSearchResults($term, Character::class);
    }

    /**
     */
    protected function familyCharacters(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);

        /** @var Builder|Character $modelClass */
        $modelClass = new Character();
        if (empty($term)) {
            $models = $modelClass
                ->with('families')
                ->limit(10)
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            $models = $modelClass
                ->with('families')
                ->where('name', 'like', "%{$term}%")
                ->limit(10)
                ->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $families = $model->families->pluck('name')->toarray();
            $format = [
                'id' => $model->id,
                'text' => $model->name . (!empty($families) ? ' (' . implode(', ', $families) . ')' : null)
            ];
            $formatted[] = $format;
        }

        return response()->json($formatted);
    }

    /**
     */
    public function families(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Family::class, $exclude);
    }

    /**
     */
    public function items(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Item::class);
    }

    /**
     */
    public function organisations(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Organisation::class, $exclude);
    }

    /**
     */
    public function events(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Event::class, $exclude);
    }

    /**
     */
    public function quests(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Quest::class, $exclude);
    }

    /**
     */
    public function calendars(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Calendar::class, $exclude);
    }

    /**
     */
    public function timelines(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Timeline::class, $exclude);
    }

    /**
     */
    public function tags(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, Tag::class, $exclude);
    }

    /**
     */
    public function diceRolls(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        return $this->buildSearchResults($term, \App\Models\DiceRoll::class);
    }

    /**
     */
    public function conversations(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Conversation::class);
    }

    /**
     */
    public function races(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Race::class, $exclude);
    }

    /**
     */
    public function creatures(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Creature::class, $exclude);
    }

    /**
     */
    public function maps(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Map::class, $exclude);
    }

    /**
     */
    public function markers(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        //parent map_id allowed for the marker (limits search to the markers of the map only)
        $include = $request->has('include') ? [$request->get('include')] : [];

        //marker must be in given map
        $modelClass = MapMarker::whereIn('map_id', $include);

        //Search text
        if (!empty($term)) {
            if (Str::startsWith($term, '=')) {
                $modelClass->where('name', mb_ltrim($term, '='));
            } else {
                $modelClass->where('name', 'like', "%{$term}%");
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

        return response()->json($formatted);
    }

    /**
     */
    public function notes(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Note::class, $exclude);
    }

    /**
     */
    public function journals(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\Journal::class, $exclude);
    }

    /**
     */
    public function abilities(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', null));
        $exclude = [];
        if ($request->has('exclude-entity')) {
            /** @var Entity $entity */
            $entity = Entity::findOrFail($request->get('exclude-entity'));
            $exclude = $entity->abilities->pluck('ability_id')->toArray();
        } elseif ($request->has('exclude')) {
            $exclude = [$request->get('exclude')];
        }
        return $this->buildSearchResults($term, \App\Models\Ability::class, $exclude);
    }

    /**
     */
    public function attributeTemplates(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);
        $exclude = $request->has('exclude') ? [$request->get('exclude')] : [];
        return $this->buildSearchResults($term, \App\Models\AttributeTemplate::class, $exclude);
    }

    /**
     * Build the search results
     */
    protected function buildSearchResults(string $term, string $class, array $excludes = [])
    {
        /** @var Builder|Tag $modelClass */
        $modelClass = new $class();
        if (empty($term)) {
            $models = $modelClass
                ->with(['entity', 'entity.image'])
                ->has('entity')
                ->whereNotIn('id', $excludes)
                ->limit(10)
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            $models = $modelClass
                ->with(['entity', 'entity.image'])
                ->has('entity')
                ->whereNotIn('id', $excludes);
            // Exact match
            if (Str::startsWith($term, '=')) {
                $models->where('name', mb_ltrim($term, '='));
            } else {
                $models->where('name', 'like', "%{$term}%");
            }
            $models = $models
                ->limit(10)
                ->get();
        }
        $formatted = [];

        /** @var \App\Models\MiscModel $model */
        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->name,
            ];
            // @phpstan-ignore-next-line
            if ($class === 'App\Models\Tag' && $model->hasColour()) {
                // @phpstan-ignore-next-line
                $format['colour'] = $model->colourClass();
            }
            if (method_exists($model, 'thumbnail')) {
                $format['image'] = Avatar::entity($model->entity)->fallback()->size(40)->thumbnail();
            }

            $formatted[] = $format;
        }

        return response()->json($formatted);
    }
}
