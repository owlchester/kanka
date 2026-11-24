<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreQuest;
use App\Http\Resources\QuestResource;
use App\Models\Campaign;
use App\Models\Quest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->quests(), QuestResource::class);
    }

    public function show(Campaign $campaign, Quest $quest): QuestResource
    {
        return new QuestResource($this->viewModel($campaign, $quest));
    }

    public function store(StoreQuest $request, Campaign $campaign): QuestResource
    {
        return new QuestResource($this->storeModel($request, $campaign, config('entities.ids.quest')));
    }

    public function update(StoreQuest $request, Campaign $campaign, Quest $quest): QuestResource
    {
        return new QuestResource($this->updateModel($request, $campaign, $quest));
    }

    public function destroy(Campaign $campaign, Quest $quest): JsonResponse
    {
        return $this->deleteModel($campaign, $quest);
    }
}
