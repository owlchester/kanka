<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationMessage;
use App\Http\Resources\Conversation\ConversationMessageResource;
use App\Http\Resources\Conversation\ConversationResource;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ConversationMessageController extends Controller
{
    /**
     * @param Conversation $conversation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Conversation $conversation)
    {
        return new ConversationResource(
            $conversation
        );
    }

    /**
     * @param StoreConversationMessage $request
     * @param Conversation $conversation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreConversationMessage $request, Conversation $conversation)
    {
        $this->authorize('update', $conversation);

        $participant = new ConversationMessage();
        $data = $request->only('message', 'character_id');
        if (!$conversation->forCharacters()) {
            $data['user_id'] = Auth::user()->id;
        }
        $data['conversation_id'] = $conversation->id;

        $participant = $participant->create($data);

        return new ConversationResource(
            $conversation
        );
    }

    public function update(StoreConversationMessage $request, Conversation $conversation, ConversationMessage $conversationMessage)
    {
        $this->authorize('update', $conversation);
        $this->authorize('edit', $conversationMessage);

        $conversationMessage->update($request->only('message'));

        if (request()->ajax()) {
            return new ConversationMessageResource($conversationMessage);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @param  \App\Models\ConversationMessage  $conversationMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation, ConversationMessage $conversationMessage)
    {
        $this->authorize('update', $conversation);
        $this->authorize('delete', $conversationMessage);

        if (!$conversationMessage->delete()) {
            abort(500);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', trans('conversations.messages.destroy.success', [
                'name' => $conversationMessage->author(),
                'conversation' => $conversation->name
            ]));
    }
}
