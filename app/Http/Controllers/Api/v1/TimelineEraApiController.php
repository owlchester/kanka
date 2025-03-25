<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreTimelineEra as Request;
use App\Http\Resources\TimelineEraResource as Resource;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Models\TimelineEra;

class TimelineEraApiController extends ApiController
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

        return Resource::collection($timeline->eras()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline->entity);

        return new Resource($timelineEra);
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
        $model = TimelineEra::create($data);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Timeline $timeline,
        TimelineEra $timelineEra
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline->entity);
        $timelineEra->update($request->all());

        return new Resource($timelineEra);
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
        TimelineEra $timelineEra
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline->entity);
        $timelineEra->delete();

        return response()->json(null, 204);
    }
}
