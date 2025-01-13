<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Tag;
use App\Services\SearchService;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    protected SearchService $search;

    /**
     * LiveController constructor.
     */
    public function __construct(SearchService $searchService)
    {
        $this->search = $searchService;
    }

    /**
     * Live Search
     */
    public function index(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));
        $type = $request->get('type', null);
        if (!empty($type)) {
            $type = mb_trim($type);
            if (!is_numeric($type)) {
                $type = config('entities.ids.' . $type);
            }
            $type = (int) $type;
        }
        $exclude = mb_trim($request->get('exclude', ''));
        if ($exclude === 'undefined') {
            $exclude = null;
        }
        $new = request()->has('new');

        if ($request->get('v2') === "true") {
            $this->search->v2();
        }

        $this->search
            ->term($term)
            ->type($type)
            ->campaign($campaign)
            ->new($new)
            ->full()
            ->excludeIds($exclude);

        return response()->json(
            $this->search->find()
        );
    }

    /**
     * Filter on entities which have reminders (entity_events)
     */
    public function reminderEntities(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));

        return response()->json(
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
     */
    public function relationEntities(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));
        $exclude = [];

        if ($request->has('exclude')) {
            $exclude = $request['exclude'];
        }

        return response()->json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->exclude([config('entities.ids.bookmark')])
                ->excludeIds($exclude)
                ->only($request->get('only'))
                ->find()
        );
    }

    /**
     * Filter on entities which have multiple tags
     */
    public function tagChildren(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));

        $exclude = [];
        if ($request->has('exclude-entity')) {
            /** @var Tag $tag */
            $tag = Tag::findOrFail($request->get('exclude-entity'));
            $exclude = $tag->entities->pluck('id')->toArray();
            $exclude[] = $tag->entity->id;
        }

        return response()->json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->excludeIds($exclude)
                ->find()
        );
    }

    /**
     * Filter on entities which aren't part of an ability
     */
    public function abilityEntities(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));

        $exclude = [];
        if ($request->has('exclude')) {
            /** @var Ability $ability */
            $ability = Ability::findOrFail($request->get('exclude'));
            $exclude = $ability->entities->pluck('id')->toArray();
        }

        return response()->json(
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
     */
    public function calendars(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));

        return response()->json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->only([config('entities.ids.calendar')])
                ->find()
        );
    }

    /**
     * Filter on org members
     */
    public function organisationMembers(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q', ''));

        $exclude = [];
        $data = [];
        if ($request->has('exclude')) {
            /** @var Organisation $org */
            $org = Organisation::findOrFail($request->get('exclude'));
            /** @var OrganisationMember $member */
            foreach ($org->members()->with('character')->has('character')->get() as $member) {
                $data[] = [
                    'id' => $member->id,
                    'text' => $member->character->name . (!empty($member->role) ? ' (' . $member->role . ')' : null)
                ];
            }
        }

        return response()->json(
            $data
        );
    }
}
