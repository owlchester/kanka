<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreConversationParticipant;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationParticipant;

class ConversationParticipantController extends Controller
{
    /**
     */
    public function index(Campaign $campaign, Conversation $conversation)
    {
        $ajax = request()->ajax();
        return view('conversations.participants', ['model' => $conversation, 'ajax' => $ajax])
            ->with('campaign', $campaign);
    }

    /**
     */
    public function store(StoreConversationParticipant $request, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('update', $conversation);

        $participant = new ConversationParticipant();
        $participant = $participant->create($request->all());

        return redirect()
            ->to($conversation->getLink())
            ->with('success', __('conversations.participants.create.success', [
                'name' => $conversation->name,
                'entity' => $participant->name()
            ]));
    }


    /**
     */
    public function edit(Campaign $campaign, Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation);

        dd('CPC 055');
    }

    /**
     */
    public function update(
        StoreConversationParticipant $request,
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('update', $conversation);

        $conversationParticipant->update($request->all());

        return redirect()
            ->to($conversation->getLink())
            ->with('success', __('crud.notes.edit.success', [
                'name' => $conversationParticipant->name, 'entity' => $conversation->name
            ]));
    }

    /**
     */
    public function destroy(Campaign $campaign, Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation);

        if (!$conversationParticipant->delete()) {
            abort(500);
        }

        return redirect()
            ->to($conversation->getLink())
            ->with('success', __('conversations.participants.destroy.success', [
                'name' => $conversation->name,
                'entity' => $conversationParticipant->entity()->name
            ]));
    }
}
