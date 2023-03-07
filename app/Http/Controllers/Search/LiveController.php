<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\Entity;
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
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->middleware('auth');
        $this->search = $searchService;
    }

    /**
     * Live Search
     */
    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->get('q'));
        $type = $request->get('type', null);
        if (!empty($type)) {
            $type = trim($type);
            if (!is_numeric($type)) {
                $type = config('entities.ids.' . $type);
            }
            $type = (int) $type;
        }
        $exclude = trim($request->get('exclude'));
        $new = request()->has('new');

        if ($request->get('v2') === "true") {
            $this->search->v2();
        }

        return response()->json(
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
     * Get a user's recent searches
     * @return never|void
     */
    public function recent()
    {
        $recent = [];
        if (auth()->check()) {
            $campaign = CampaignLocalization::getCampaign();

            $recent = $this->search
                ->campaign($campaign)
                ->user(auth()->user())
                ->recent();
        }

        return response()->json([
            'recent' => $recent,
            'texts' => [
                'recents' => __('search.lookup.recents'),
                'hint' => __('search.lookup.hint')
            ],
        ]);
    }

    /**
     * Filter on entities which have reminders (entity_events)
     * @param Request $request
     * @return mixed
     */
    public function reminderEntities(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->q);

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
     * @param Request $request
     * @return mixed
     */
    public function relationEntities(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->q);
        $exclude = [];

        if ($request->has('exclude')) {
            $exclude = $request['exclude'];
        }

        return response()->json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->exclude([config('entities.ids.menu_link')])
                ->excludeIds($exclude)
                ->find()
        );
    }

    /**
     * Filter on entities which have multiple tags
     * @param Request $request
     * @return mixed
     */
    public function tagChildren(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->q);

        $exclude = [];
        if ($request->has('exclude')) {
            /** @var Tag $tag */
            $tag = Tag::findOrFail($request->get('exclude'));
            $exclude = $tag->entities->pluck('id')->toArray();
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
     * Filter on entities which aren't part of an ability
     * @param Request $request
     * @return mixed
     */
    public function abilityEntities(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->q);

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
     * @param Request $request
     * @return mixed
     */
    public function calendars(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->q);

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
     * @param Request $request
     * @return mixed
     */
    public function organisationMembers(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = trim($request->q);

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
