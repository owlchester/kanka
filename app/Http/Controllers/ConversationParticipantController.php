<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationParticipant;
use App\Models\Conversation;
use App\Models\ConversationParticipant;

class ConversationParticipantController extends Controller
{
    /**
     */
    public function index(Conversation $conversation)
    {
        $ajax = request()->ajax();
        return view('conversations.participants', ['model' => $conversation, 'ajax' => $ajax]);
    }

    /**
     */
    public function store(StoreConversationParticipant $request, Conversation $conversation)
    {
        $this->authorize('update', $conversation);

        $participant = new ConversationParticipant();
        $participant = $participant->create($request->all());

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', trans('conversations.participants.create.success', [
                'name' => $conversation->name,
                'entity' => $participant->entity()->name
            ]));
    }


    /**
     */
    public function edit(Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation);

        dd('CPC 055');
    }

    /**
     */
    public function update(
        StoreConversationParticipant $request,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('update', $conversation);

        $conversationParticipant->update($request->all());

        return redirect()->route('conversations.show', [$conversation->child->id, $this->tab])
            ->with('success', trans('crud.notes.edit.success', [
                'name' => $conversationParticipant->name, 'entity' => $conversation->name
            ]));
    }

    /**
     */
    public function destroy(Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation);

        if (!$conversationParticipant->delete()) {
            abort(500);
        }

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', trans('conversations.participants.destroy.success', [
                'name' => $conversation->name,
                'entity' => $conversationParticipant->entity()->name
            ]));
    }
}
