<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreTimelineElement as Request;
use App\Http\Resources\TimelineElementResource as Resource;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Models\TimelineElement;

class TimelineElementApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline->entity);

        return Resource::collection($timeline->elements()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Timeline $timeline, TimelineElement $timelineElement)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline->entity);

        return new Resource($timelineElement);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline->entity);
        $data = $request->all();
        $data['timeline_id'] = $timeline->id;
        $model = TimelineElement::create($data);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineElement $timelineElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline->entity);
        $timelineElement->update($request->all());

        return new Resource($timelineElement);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineElement $timelineElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline->entity);
        $timelineElement->delete();

        return response()->json(null, 204);
    }
}
