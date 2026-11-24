<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreRace;
use App\Http\Resources\RaceResource;
use App\Models\Campaign;
use App\Models\Race;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RaceApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->races(), RaceResource::class);
    }

    public function show(Campaign $campaign, Race $race): RaceResource
    {
        return new RaceResource($this->viewModel($campaign, $race));
    }

    public function store(StoreRace $request, Campaign $campaign): RaceResource
    {
        return new RaceResource($this->storeModel($request, $campaign, config('entities.ids.race')));
    }

    public function update(StoreRace $request, Campaign $campaign, Race $race): RaceResource
    {
        return new RaceResource($this->updateModel($request, $campaign, $race));
    }

    public function destroy(Campaign $campaign, Race $race): JsonResponse
    {
        return $this->deleteModel($campaign, $race);
    }
}
