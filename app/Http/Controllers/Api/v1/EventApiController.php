<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreEvent;
use App\Http\Resources\EventResource;
use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->events(), EventResource::class);
    }

    public function show(Campaign $campaign, Event $event): EventResource
    {
        return new EventResource($this->viewModel($campaign, $event));
    }

    public function store(StoreEvent $request, Campaign $campaign): EventResource
    {
        return new EventResource($this->storeModel($request, $campaign, config('entities.ids.event')));
    }

    public function update(StoreEvent $request, Campaign $campaign, Event $event): EventResource
    {
        return new EventResource($this->updateModel($request, $campaign, $event));
    }

    public function destroy(Campaign $campaign, Event $event): JsonResponse
    {
        return $this->deleteModel($campaign, $event);
    }
}
