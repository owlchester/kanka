<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Timeline;
use App\Models\Campaign;
use App\Models\TimelineEra;
use App\Http\Requests\StoreTimelineEra as Request;
use App\Http\Resources\TimelineEraResource as Resource;

class TimelineEraApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline);
        return Resource::collection($timeline->layers()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param TimelineEra $timelineEra
     * @return Resource
     */
    public function show(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline);
        return new Resource($timelineEra);
    }

    /**
     * @param StoreTimelineEra $retimelineEra
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $model = TimelineEra::create($request->all());
        return new Resource($model);
    }

    /**
     * @param StoreTimelineEra $retimelineEra
     * @param Campaign $campaign
     * @param TimelineEra $timelineEra
     * @return Resource
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineEra $timelineEra
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $timelineEra->update($request->all());

        return new Resource($timelineEra);
    }

    /**
     * @param Request
     * @param Campaign $campaign
     * @param TimelineEra $timelineEra
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineEra $timelineEra
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $timelineEra->delete();

        return response()->json(null, 204);
    }
}
