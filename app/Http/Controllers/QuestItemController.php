<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestItem;
use App\Http\Requests\StoreQuestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestItemController extends QuestForeignController
{
    /**
     * @var string
     */
    protected $view = 'quests.items';

    /**
     * @var string
     */
    protected $route = 'quests.quest_items';

    /**
     * Redirect tab after manipulating
     * @var string
     */
    protected $tab = 'item';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'attributes';

    /**
     * @var string
     */
    protected $model = \App\Models\QuestItem::class;

    /**
     * @param Quest $quest
     * @return \Illuminate\Http\Response
     */
    public function index(Quest $quest)
    {
        return $this->crudIndex($quest);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Quest $quest)
    {
        return $this->crudCreate($quest);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestItem $request, Quest $quest)
    {
        return $this->crudStore($request, $quest);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest, QuestItem $questItem)
    {
        return $this->crudEdit($quest, $questItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestItem $request, Quest $quest, QuestItem $questItem)
    {
        return $this->crudUpdate($request, $quest, $questItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestItem  $questItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quest $quest, QuestItem $questItem)
    {
        return $this->crudDestroy($quest, $questItem);
    }
}
