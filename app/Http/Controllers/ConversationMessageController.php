<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationMessage;
use App\Http\Resources\Conversation\ConversationMessageResource;
use App\Http\Resources\Conversation\ConversationResource;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Entity;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ConversationMessageController extends Controller
{
    /**
     * @return ConversationResource
     */
    public function index(Campaign $campaign, Conversation $conversation)
    {
        return new ConversationResource(
            $conversation
        );
    }

    /**
     * @return ConversationResource
     *
     * @throws AuthorizationException
     */
    public function store(StoreConversationMessage $request, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('update', $conversation->entity);

        $data = ['message' => $request->validated('message')];
        if (! $conversation->forEntities()) {
            $participant = Auth::user();
        } else {
            $participant = Entity::findOrFail($request->validated('entity_id'));
        }
        $message = new ConversationMessage($data);
        $message->conversation()->associate($conversation);
        $message->participant()->associate($participant);
        $message->save();

        return new ConversationResource(
            $conversation
        );
    }

    public function update(StoreConversationMessage $request, Campaign $campaign, Conversation $conversation, ConversationMessage $conversationMessage)
    {
        $this->authorize('update', $conversation->entity);
        $this->authorize('edit', $conversationMessage);

        $conversationMessage->update($request->only('message'));

        if (request()->ajax()) {
            return new ConversationMessageResource($conversationMessage);
        }
    }

    /**
     * @return JsonResponse|RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Conversation $conversation, ConversationMessage $conversationMessage)
    {
        $this->authorize('update', $conversation->entity);
        $this->authorize('delete', $conversationMessage);

        if (! $conversationMessage->delete()) {
            abort(500);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('entities.show', [$campaign, $conversation->entity])
            ->with('success', trans('conversations.messages.destroy.success', [
                'name' => $conversationMessage->author(),
                'conversation' => $conversation->entity->name,
            ]));
    }
}
