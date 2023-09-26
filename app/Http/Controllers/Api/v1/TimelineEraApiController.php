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
     * @return Resource
     */
    public function show(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline);
        return new Resource($timelineEra);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $data = $request->all();
        $data['timeline_id'] = $timeline->id;
        $model = TimelineEra::create($data);
        return new Resource($model);
    }

    /**
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
