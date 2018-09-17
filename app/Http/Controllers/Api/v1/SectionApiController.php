<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Section;
use App\Http\Requests\StoreSection as Request;
use App\Http\Resources\Section as Resource;
use App\Http\Resources\SectionCollection as Collection;

class SectionApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return new Collection($campaign->sections);
    }

    /**
     * @param Campaign $campaign
     * @param Section $section
     * @return Resource
     */
    public function show(Campaign $campaign, Section $section)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $section);
        return new Resource($section);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Section::class);
        $model = Section::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Section $section
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Section $section)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $section);
        $section->update($request->all());

        return new Resource($section);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, Section $section)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $section);
        $section->delete();

        return response()->json(null, 204);
    }
}
