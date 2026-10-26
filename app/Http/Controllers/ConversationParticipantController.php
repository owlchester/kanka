<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationParticipant;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Entity;
use App\Models\User;

class ConversationParticipantController extends Controller
{
    public function index(Campaign $campaign, Conversation $conversation)
    {
        return view('conversations.participants', ['campaign' => $campaign, 'model' => $conversation]);
    }

    public function store(StoreConversationParticipant $request, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('update', $conversation->entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->validated();
        $participantClass = isset($data['entity_ids']) || isset($data['entity_id']) ? Entity::class : User::class;
        $participants = collect($data['entity_ids'] ?? $data['user_ids'] ?? [$data['entity_id'] ?? $data['user_id']])
            ->filter()
            ->unique()
            ->map(function ($id) use ($conversation, $participantClass) {
                if ($conversation->participants()
                    ->where('participant_type', $participantClass)
                    ->where('participant_id', $id)
                    ->exists()) {
                    return null;
                }

                $participant = new ConversationParticipant;
                $participant->conversation()->associate($conversation);
                $participant->participant()->associate($participantClass::findOrFail($id));
                $participant->save();

                return $participant;
            })
            ->filter();
        $participant = $participants->first();

        if (! $participant) {
            return back();
        }

        return redirect()
            ->route('entities.show', [$campaign, $conversation->entity])
            ->with('success', __('conversations.participants.create.success', [
                'name' => $conversation->entity->name,
                'entity' => $participants->map(fn (ConversationParticipant $participant) => $participant->name())->join(', '),
            ]));
    }

    private function participantFromRequest(array $data): Entity|User
    {
        return isset($data['entity_id'])
            ? Entity::findOrFail($data['entity_id'])
            : User::findOrFail($data['user_id']);
    }

    public function edit(Campaign $campaign, Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation->entity);

        dd('CPC 055');
    }

    public function update(
        StoreConversationParticipant $request,
        Campaign $campaign,
        Conversation $conversation,
        ConversationParticipant $conversationParticipant
    ) {
        $this->authorize('update', $conversation->entity);

        $conversationParticipant->update($request->all());

        return redirect()
            ->route('entities.show', [$campaign, $conversation->entity])
            ->with('success', trans('crud.notes.edit.success', [
                'name' => $conversationParticipant->entity()->name, 'entity' => $conversation->entity->name,
            ]));
    }

    public function destroy(Campaign $campaign, Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation->entity);

        if (! $conversationParticipant->delete()) {
            abort(500);
        }

        return redirect()
            ->route('entities.show', [$campaign, $conversation->entity])
            ->with('success', trans('conversations.participants.destroy.success', [
                'name' => $conversation->entity->name,
                'entity' => $conversationParticipant->entity()->name,
            ]));
    }
}
