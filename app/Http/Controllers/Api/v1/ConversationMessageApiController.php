<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreConversationMessage as RequestMessage;
use App\Http\Resources\ConversationMessageResource as Resource;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConversationMessageApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation->entity);

        return Resource::collection(
            $conversation
                ->messages()
                ->lastSync(request()->get('lastSync'))
                ->paginate()
        );
    }

    /**
     * @return resource
     */
    public function show(
        Campaign $campaign,
        Conversation $conversation,
        ConversationMessage $conversationMessage
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation->entity);

        return new Resource($conversationMessage);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(RequestMessage $requestMessage, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $model = ConversationMessage::create($requestMessage->all());

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(
        RequestMessage $requestMessage,
        Campaign $campaign,
        Conversation $conversation,
        ConversationMessage $conversationMessage
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $conversationMessage->update($requestMessage->all());

        return new Resource($conversationMessage);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(
        Request $request,
        Campaign $campaign,
        Conversation $conversation,
        ConversationMessage $conversationMessage
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $conversationMessage->delete();

        return response()->json(null, 204);
    }
}
