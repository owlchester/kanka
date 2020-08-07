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
     * @param StoreTimelineElement $retimelineElement
     * @param Campaign $campaign
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
     * @param StoreTimelineElement $retimelineElement
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
     * @param Request
     * @param Campaign $campaign
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
