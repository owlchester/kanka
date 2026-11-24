<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreItem;
use App\Http\Resources\ItemResource;
use App\Models\Campaign;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->items(), ItemResource::class);
    }

    public function show(Campaign $campaign, Item $item): ItemResource
    {
        return new ItemResource($this->viewModel($campaign, $item));
    }

    public function store(StoreItem $request, Campaign $campaign): ItemResource
    {
        return new ItemResource($this->storeModel($request, $campaign, config('entities.ids.item')));
    }

    public function update(StoreItem $request, Campaign $campaign, Item $item): ItemResource
    {
        return new ItemResource($this->updateModel($request, $campaign, $item));
    }

    public function destroy(Campaign $campaign, Item $item): JsonResponse
    {
        return $this->deleteModel($campaign, $item);
    }
}
