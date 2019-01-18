<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuest;
use App\Models\Character;
use App\Models\Quest;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'quests';
    protected $route = 'quests';

    /**
     * @var string
     */
    protected $model = \App\Models\Quest::class;

    /**
     * QuestController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
            [
                'field' => 'character_id',
                'label' => trans('quests.fields.character'),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  trans('crud.placeholders.character'),
                'model' => Character::class,
            ],
            [
                'field' => 'quest_id',
                'label' => trans('quests.fields.quest'),
                'type' => 'select2',
                'route' => route('quests.find'),
                'placeholder' =>  trans('quests.placeholders.quest'),
                'model' => Quest::class,
            ],
            [
                'field' => 'tag_id',
                'label' => trans('crud.fields.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  trans('crud.placeholders.tag'),
                'model' => Tag::class,
            ],
            'is_completed',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuest $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Quest $quest)
    {
        return $this->crudShow($quest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest)
    {
        return $this->crudEdit($quest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuest $request, Quest $quest)
    {
        return $this->crudUpdate($request, $quest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quest $quest)
    {
        return $this->crudDestroy($quest);
    }


    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function characters(Quest $quest)
    {
        return $this->menuView($quest, 'characters');
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function locations(Quest $quest)
    {
        return $this->menuView($quest, 'locations');
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function items(Quest $quest)
    {
        return $this->menuView($quest, 'items');
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function organisations(Quest $quest)
    {
        return $this->menuView($quest, 'organisations');
    }
}
