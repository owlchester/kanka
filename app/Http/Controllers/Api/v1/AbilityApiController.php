<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreAbility;
use App\Http\Resources\AbilityResource;
use App\Models\Ability;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AbilityApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->abilities(), AbilityResource::class);
    }

    public function show(Campaign $campaign, Ability $ability): AbilityResource
    {
        return new AbilityResource($this->viewModel($campaign, $ability));
    }

    public function store(StoreAbility $request, Campaign $campaign): AbilityResource
    {
        return new AbilityResource($this->storeModel($request, $campaign, config('entities.ids.ability')));
    }

    public function update(StoreAbility $request, Campaign $campaign, Ability $ability): AbilityResource
    {
        return new AbilityResource($this->updateModel($request, $campaign, $ability));
    }

    public function destroy(Campaign $campaign, Ability $ability): JsonResponse
    {
        return $this->deleteModel($campaign, $ability);
    }
}
