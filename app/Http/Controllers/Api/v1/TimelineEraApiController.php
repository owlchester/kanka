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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline);
        return Resource::collection($timeline->eras()->paginate());
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
     * @param Request $request
     * @param Campaign $campaign
     * @param Timeline $timeline
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
     * @param Request $request
     * @param Campaign $campaign
     * @param Timeline $timeline
     * @param TimelineEra $timelineEra
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param Timeline $timeline
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
