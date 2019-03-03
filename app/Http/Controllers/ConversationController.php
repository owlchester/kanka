<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversation;
use App\Models\Conversation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ConversationController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'conversations';
    protected $route = 'conversations';

    /**
     * @var string
     */
    protected $model = \App\Models\Conversation::class;

    /**
     * CalendarController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
            [
                'field' => 'target',
                'label' => trans('conversations.fields.target'),
                'valueKey' => 'conversations.targets.',
                'type' => 'select',
                'placeholder' =>  trans('conversations.placeholders.target'),
                'data' => trans('conversations.targets')
            ],
            [
                'field' => 'tag_id',
                'label' => trans('crud.fields.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  trans('crud.placeholders.tag'),
                'model' => Tag::class,
            ],
        ];
    }

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
        return $this->crudShow($conversation);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Conversation $conversation)
    {
        return $this->menuView($conversation, 'map-points', true);
    }
}
