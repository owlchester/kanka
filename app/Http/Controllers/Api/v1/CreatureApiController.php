<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCreature;
use App\Http\Resources\CreatureResource;
use App\Models\Campaign;
use App\Models\Creature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CreatureApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->creatures(), CreatureResource::class);
    }

    public function show(Campaign $campaign, Creature $creature): CreatureResource
    {
        return new CreatureResource($this->viewModel($campaign, $creature));
    }

    public function store(StoreCreature $request, Campaign $campaign): CreatureResource
    {
        return new CreatureResource($this->storeModel($request, $campaign, config('entities.ids.creature')));
    }

    public function update(StoreCreature $request, Campaign $campaign, Creature $creature): CreatureResource
    {
        return new CreatureResource($this->updateModel($request, $campaign, $creature));
    }

    public function destroy(Campaign $campaign, Creature $creature): JsonResponse
    {
        return $this->deleteModel($campaign, $creature);
    }
}
