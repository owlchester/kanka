<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Timeline;
use App\Http\Requests\StoreTimeline as Request;
use App\Http\Resources\TimelineResource as Resource;

class TimelineApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->timelines()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Timeline $timeline
     * @return Resource
     */
    public function show(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $timeline);
        return new Resource($timeline);
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
        $this->authorize('create', Timeline::class);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Timeline::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Timeline $timeline
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $timeline);
        $timeline->update($request->all());
        $this->crudSave($timeline);

        return new Resource($timeline);
    }

    /**
     * @param Campaign $campaign
     * @param Timeline $timeline
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $timeline);
        $timeline->delete();

        return response()->json(null, 204);
    }
}
