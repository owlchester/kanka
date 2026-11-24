<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCharacter;
use App\Http\Resources\CharacterResource;
use App\Models\Campaign;
use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CharacterApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->characters(), CharacterResource::class, loadBeforeFiltering: true);
    }

    public function show(Campaign $campaign, Character $character): CharacterResource
    {
        return new CharacterResource($this->viewModel($campaign, $character));
    }

    public function store(StoreCharacter $request, Campaign $campaign): CharacterResource
    {
        return new CharacterResource($this->storeModel($request, $campaign, config('entities.ids.character')));
    }

    public function update(StoreCharacter $request, Campaign $campaign, Character $character): CharacterResource
    {
        return new CharacterResource($this->updateModel($request, $campaign, $character));
    }

    public function destroy(Campaign $campaign, Character $character): JsonResponse
    {
        return $this->deleteModel($campaign, $character);
    }
}
