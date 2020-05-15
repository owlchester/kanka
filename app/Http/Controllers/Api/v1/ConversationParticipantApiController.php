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
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation);
        return Resource::collection($conversation->participants()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param ConversationParticipant $conversationParticipant
     * @return Resource
     */
    public function show(
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation);
        return new Resource($conversationParticipant);
    }

    /**
     * @param RequestParticipant $requestParticipant
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestParticipant $requestParticipant, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation);
        $model = ConversationParticipant::create($requestParticipant->all());
        return new Resource($model);
    }

    /**
     * @param RequestParticipant $requestParticipant
     * @param Campaign $campaign
     * @param ConversationParticipant $conversationParticipant
     * @return Resource
     */
    public function update(
        RequestParticipant $requestParticipant,
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation);
        $conversationParticipant->update($requestParticipant->all());

        return new Resource($conversationParticipant);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param ConversationParticipant $conversationParticipant
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
        $this->authorize('update', $conversation);
        $conversationParticipant->delete();

        return response()->json(null, 204);
    }
}
