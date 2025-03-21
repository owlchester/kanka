<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreConversationParticipant as RequestParticipant;
use App\Http\Resources\ConversationParticipantResource as Resource;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationParticipant;

class ConversationParticipantApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation->entity);

        return Resource::collection($conversation->participants()->paginate());
    }

    /**
     * @return resource
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
     * @return resource
     *
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
     * @return resource
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
     *
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
