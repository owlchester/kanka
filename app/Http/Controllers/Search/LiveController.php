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
    public function __construct(protected SearchService $searchService)
    {
    }

    public function index(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');
        $exclude = mb_trim($request->get('exclude') ?? '');
        if ($exclude === 'undefined') {
            $exclude = null;
        }
        if (request()->has('new')) {
            $this->searchService->new(true);
        }
        if ($request->get('v2') === "true") {
            $this->searchService->v2();
        }
        if ($request->has('posts')) {
            $this->searchService->posts()->new();
        }

        $this->searchService
            ->term($term)
            ->campaign($campaign)
            ->full()
            ->excludeIds($exclude);

        return response()->json(
            $this->searchService->find()
        );
    }

    /**
     * Filter on entities which have reminders (entity_events)
     */
    public function reminderEntities(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');

        return response()->json(
            $this->searchService
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
        $term = mb_trim($request->get('q') ?? '');
        $exclude = [];

        if ($request->has('exclude')) {
            $exclude = $request['exclude'];
        }

        return response()->json(
            $this->searchService
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
        $term = mb_trim($request->get('q') ?? '');

        $exclude = [];
        if ($request->has('exclude-entity')) {
            /** @var Tag $tag */
            $tag = Tag::findOrFail($request->get('exclude-entity'));
            $exclude = $tag->entities->pluck('id')->toArray();
            $exclude[] = $tag->entity->id;
        }

        return response()->json(
            $this->searchService
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
        $term = mb_trim($request->get('q') ?? '');

        $exclude = [];
        if ($request->has('exclude')) {
            /** @var Ability $ability */
            $ability = Ability::findOrFail($request->get('exclude'));
            $exclude = $ability->entities->pluck('id')->toArray();
        }

        return response()->json(
            $this->searchService
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
        $term = mb_trim($request->get('q') ?? '');

        return response()->json(
            $this->searchService
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
        $term = mb_trim($request->get('q') ?? '');

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
