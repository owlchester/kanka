<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationParticipant;
use App\Models\Conversation;
use App\Models\ConversationParticipant;

class ConversationParticipantController extends Controller
{
    /**
     * @param Conversation $conversation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Conversation $conversation)
    {
        $ajax = request()->ajax();
        return view('conversations.participants', ['model' => $conversation, 'ajax' => $ajax]);
    }

    /**
     * @param StoreConversationParticipant $request
     * @param Conversation $conversation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation);

        $name = $conversation->pluralType() . '.notes' . $this->view;
        $route = 'entities.' . $this->route;
        $parentRoute = $conversation->pluralType();
        $model = $conversationParticipant;

        return view('cruds.notes.edit', compact(
            'entity',
            'model',
            'name',
            'route',
            'parentRoute'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConversationParticipant $request, Conversation $conversation, ConversationParticipant $conversationParticipant)
    {
        $this->authorize('update', $conversation);

        $conversationParticipant->update($request->all());

        return redirect()->route($conversation->pluralType() . '.show', [$conversation->child->id, $this->tab])
            ->with('success', trans('crud.notes.edit.success', ['name' => $conversationParticipant->name, 'entity' => $conversation->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @param  \App\Models\ConversationParticipant  $conversationParticipant
     * @return \Illuminate\Http\Response
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
