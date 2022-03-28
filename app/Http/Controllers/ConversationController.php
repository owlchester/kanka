<?php

namespace App\Http\Controllers;

use App\Datagrids\ConversationDatagrid;
use App\Datagrids\Filters\ConversationFilter;
use App\Http\Requests\StoreConversation;
use App\Models\Conversation;

class ConversationController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'conversations';
    protected $route = 'conversations';
    protected $module = 'conversations';

    /** @var string Model */
    protected $model = \App\Models\Conversation::class;

    /** @var string Filter */
    protected $filter = ConversationFilter::class;

    /** @var string  */
    protected $datagrid = ConversationDatagrid::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConversation $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $conversation);
        } else {
            $this->authorizeForGuest('read', $conversation);
        }
        $name = $this->view;
        $ajax = request()->ajax();
        $model = $conversation;
        $translations = json_encode([
            'edit' => __('crud.edit'),
            'remove' => __('crud.remove'),
            'is_updated' => __('conversations.messages.is_updated'),
            'is_closed' => __('conversations.show.is_closed'),
            'load_previous' => __('conversations.messages.load_previous'),
            'user_unknown' => __('crud.users.unknown'),
        ]);

        return view(
            'cruds.show',
            compact('model', 'name', 'ajax', 'translations')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        return $this->crudEdit($conversation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConversation $request, Conversation $conversation)
    {
        return $this->crudUpdate($request, $conversation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        return $this->crudDestroy($conversation);
    }
}
