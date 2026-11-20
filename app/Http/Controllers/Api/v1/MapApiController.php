<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMap;
use App\Http\Resources\MapResource;
use App\Models\Campaign;
use App\Models\Map;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MapApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->maps(), MapResource::class);
    }

    public function show(Campaign $campaign, Map $map): MapResource
    {
        return new MapResource($this->viewModel($campaign, $map));
    }

    public function store(StoreMap $request, Campaign $campaign): MapResource
    {
        return new MapResource($this->storeModel($request, $campaign, config('entities.ids.map')));
    }

    public function update(StoreMap $request, Campaign $campaign, Map $map): MapResource
    {
        return new MapResource($this->updateModel($request, $campaign, $map));
    }

    public function destroy(Campaign $campaign, Map $map): JsonResponse
    {
        return $this->deleteModel($campaign, $map);
    }
}
