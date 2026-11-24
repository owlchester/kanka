<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreFamily;
use App\Http\Resources\FamilyResource;
use App\Models\Campaign;
use App\Models\Family;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FamilyApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->families(), FamilyResource::class);
    }

    public function show(Campaign $campaign, Family $family): FamilyResource
    {
        return new FamilyResource($this->viewModel($campaign, $family));
    }

    public function store(StoreFamily $request, Campaign $campaign): FamilyResource
    {
        return new FamilyResource($this->storeModel($request, $campaign, config('entities.ids.family')));
    }

    public function update(StoreFamily $request, Campaign $campaign, Family $family): FamilyResource
    {
        return new FamilyResource($this->updateModel($request, $campaign, $family));
    }

    public function destroy(Campaign $campaign, Family $family): JsonResponse
    {
        return $this->deleteModel($campaign, $family);
    }
}
