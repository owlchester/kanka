<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestCharacter;
use App\Http\Requests\StoreQuestCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestCharacterController extends QuestForeignController
{
    /**
     * @var string
     */
    protected $view = 'quests.characters';

    /**
     * @var string
     */
    protected $route = 'quests.quest_characters';

    /**
     * Redirect tab after manipulating
     * @var string
     */
    protected $tab = 'character';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'attributes';

    /**
     * @var string
     */
    protected $model = \App\Models\QuestCharacter::class;

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
    public function store(StoreQuestCharacter $request, Quest $quest)
    {
        return $this->crudStore($request, $quest);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest, QuestCharacter $questCharacter)
    {
        return $this->crudEdit($quest, $questCharacter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestCharacter $request, Quest $quest, QuestCharacter $questCharacter)
    {
        return $this->crudUpdate($request, $quest, $questCharacter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestCharacter  $questCharacter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quest $quest, QuestCharacter $questCharacter)
    {
        return $this->crudDestroy($quest, $questCharacter);
    }
}
