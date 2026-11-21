<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationMessage;
use App\Http\Resources\Conversation\ConversationMessageResource;
use App\Http\Resources\Conversation\ConversationResource;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConversationMessageController extends Controller
{
    public function index(Request $request, Campaign $campaign, Conversation $conversation): ConversationResource
    {
        abort_unless($conversation->campaign_id === $campaign->id && $conversation->entity, 404);
        $this->authorize('view', $conversation->entity);

        $request->validate([
            'oldest' => ['nullable', 'integer', 'min:1', 'prohibits:newest'],
            'newest' => ['nullable', 'integer', 'min:0'],
        ]);

        return new ConversationResource($conversation);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreConversationMessage $request, Campaign $campaign, Conversation $conversation): ConversationMessageResource
    {
        abort_unless($conversation->campaign_id === $campaign->id && $conversation->entity, 404);
        $this->authorize('update', $conversation->entity);
        abort_if($conversation->is_closed, 403, __('conversations.show.is_closed'));

        $participant = $request->user();
        if ($conversation->forEntities()) {
            $participant = $conversation->postingParticipants($participant)[$request->validated('entity_id')] ?? null;
            if (! $participant) {
                throw ValidationException::withMessages([
                    'entity_id' => __('conversations.messages.invalid_speaker'),
                ]);
            }
        }
        $message = new ConversationMessage(['message' => $request->validated('message')]);
        $message->conversation()->associate($conversation);
        $message->participant()->associate($participant);
        $message->save();

        return new ConversationMessageResource($message);
    }

    public function update(StoreConversationMessage $request, Campaign $campaign, Conversation $conversation, ConversationMessage $conversationMessage): ConversationMessageResource
    {
        abort_unless($conversation->campaign_id === $campaign->id && $conversation->entity && $conversationMessage->conversation_id === $conversation->id, 404);
        $this->authorize('update', $conversation->entity);
        $this->authorize('edit', $conversationMessage);
        abort_if($conversation->is_closed, 403, __('conversations.show.is_closed'));

        $conversationMessage->update(['message' => $request->validated('message')]);

        return new ConversationMessageResource($conversationMessage);
    }

    /**
     * @return JsonResponse|RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Conversation $conversation, ConversationMessage $conversationMessage)
    {
        abort_unless($conversation->campaign_id === $campaign->id && $conversation->entity && $conversationMessage->conversation_id === $conversation->id, 404);
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
