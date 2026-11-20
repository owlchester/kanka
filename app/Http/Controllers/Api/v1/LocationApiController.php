<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreLocation;
use App\Http\Resources\LocationResource;
use App\Models\Campaign;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LocationApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->locations(), LocationResource::class);
    }

    public function show(Campaign $campaign, Location $location): LocationResource
    {
        return new LocationResource($this->viewModel($campaign, $location));
    }

    public function store(StoreLocation $request, Campaign $campaign): LocationResource
    {
        return new LocationResource($this->storeModel($request, $campaign, config('entities.ids.location')));
    }

    public function update(StoreLocation $request, Campaign $campaign, Location $location): LocationResource
    {
        return new LocationResource($this->updateModel($request, $campaign, $location));
    }

    public function destroy(Campaign $campaign, Location $location): JsonResponse
    {
        return $this->deleteModel($campaign, $location);
    }
}
