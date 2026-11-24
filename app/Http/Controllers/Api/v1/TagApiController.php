<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreTag;
use App\Http\Resources\TagResource;
use App\Models\Campaign;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->tags(), TagResource::class);
    }

    public function show(Campaign $campaign, Tag $tag): TagResource
    {
        return new TagResource($this->viewModel($campaign, $tag));
    }

    public function store(StoreTag $request, Campaign $campaign): TagResource
    {
        return new TagResource($this->storeModel($request, $campaign, config('entities.ids.tag')));
    }

    public function update(StoreTag $request, Campaign $campaign, Tag $tag): TagResource
    {
        return new TagResource($this->updateModel($request, $campaign, $tag));
    }

    public function destroy(Campaign $campaign, Tag $tag): JsonResponse
    {
        return $this->deleteModel($campaign, $tag);
    }
}
