<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreTimeline;
use App\Http\Resources\TimelineResource;
use App\Models\Campaign;
use App\Models\Timeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TimelineApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->timelines(), TimelineResource::class);
    }

    public function show(Campaign $campaign, Timeline $timeline): TimelineResource
    {
        return new TimelineResource($this->viewModel($campaign, $timeline));
    }

    public function store(StoreTimeline $request, Campaign $campaign): TimelineResource
    {
        return new TimelineResource($this->storeModel($request, $campaign, config('entities.ids.timeline')));
    }

    public function update(StoreTimeline $request, Campaign $campaign, Timeline $timeline): TimelineResource
    {
        return new TimelineResource($this->updateModel($request, $campaign, $timeline));
    }

    public function destroy(Campaign $campaign, Timeline $timeline): JsonResponse
    {
        return $this->deleteModel($campaign, $timeline);
    }
}
