<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Timeline;
use App\Models\Campaign;
use App\Models\TimelineElement;
use App\Http\Requests\StoreTimelineElement as Request;
use App\Http\Resources\TimelineElementResource as Resource;

class TimelineElementApiController extends ApiController
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
        return Resource::collection($timeline->elements()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param TimelineElement $timelineElement
     * @return Resource
     */
    public function show(Campaign $campaign, Timeline $timeline, TimelineElement $timelineElement)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline);
        return new Resource($timelineElement);
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
        $model = TimelineElement::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param TimelineElement $timelineElement
     * @return Resource
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineElement $timelineElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $timelineElement->update($request->all());

        return new Resource($timelineElement);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param Timeline $timeline
     * @param TimelineElement $timelineElement
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineElement $timelineElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $timelineElement->delete();

        return response()->json(null, 204);
    }
}
