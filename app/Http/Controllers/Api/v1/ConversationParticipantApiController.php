<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Conversation;
use App\Models\Campaign;
use App\Models\ConversationParticipant;
use App\Http\Requests\StoreConversationParticipant as RequestParticipant;
use App\Http\Resources\ConversationParticipantResource as Resource;

class ConversationParticipantApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation->entity);
        return Resource::collection($conversation->participants()->paginate());
    }

    /**
     * @return Resource
     */
    public function show(
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation->entity);
        return new Resource($conversationParticipant);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestParticipant $requestParticipant, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $model = ConversationParticipant::create($requestParticipant->all());
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(
        RequestParticipant $requestParticipant,
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $conversationParticipant->update($requestParticipant->all());

        return new Resource($conversationParticipant);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $conversationParticipant->delete();

        return response()->json(null, 204);
    }
}
