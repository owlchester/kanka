<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationMessage;
use App\Models\Conversation;
use App\Models\ConversationMessage;

class ConversationMessageController extends Controller
{
    /**
     * @param Conversation $conversation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Conversation $conversation)
    {
        $ajax = request()->ajax();

        return view('conversations._latest', [
            'model' => $conversation,
            'oldest' => request()->get('oldest', null),
            'newest' => null,
            'ajax' => $ajax
        ]);
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
        $participant = $participant->create($request->all());

        if (request()->ajax()) {
            return view('conversations._latest', [
                'model' => $conversation,
                'oldest' => null,
                'newest' => request()->get('newest')
            ]);
        }

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', trans('conversations.messages.create.success', [
                'name' => $conversation->name, 'entity' => $participant->author()
            ]));
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
            return view('conversations._latest', [
                'model' => $conversation,
                'oldest' => null,
                'newest' => request()->get('newest')
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
