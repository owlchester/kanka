<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreConversation;
use App\Http\Resources\ConversationResource;
use App\Models\Campaign;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConversationApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->conversations(), ConversationResource::class);
    }

    public function show(Campaign $campaign, Conversation $conversation): ConversationResource
    {
        return new ConversationResource($this->viewModel($campaign, $conversation));
    }

    public function store(StoreConversation $request, Campaign $campaign): ConversationResource
    {
        return new ConversationResource($this->storeModel($request, $campaign, config('entities.ids.conversation')));
    }

    public function update(StoreConversation $request, Campaign $campaign, Conversation $conversation): ConversationResource
    {
        return new ConversationResource($this->updateModel($request, $campaign, $conversation));
    }

    public function destroy(Campaign $campaign, Conversation $conversation): JsonResponse
    {
        return $this->deleteModel($campaign, $conversation);
    }
}
