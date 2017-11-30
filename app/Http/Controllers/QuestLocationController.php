<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestLocation;
use App\Http\Requests\StoreQuestLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestLocationController extends CrudAttributeController
{
    /**
     * @var string
     */
    protected $view = 'quests.locations';

    /**
     * @var string
     */
    protected $route = 'quests.quest_locations';

    /**
     * Redirect tab after manipulating
     * @var string
     */
    protected $tab = 'location';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'attributes';

    /**
     * @var string
     */
    protected $model = \App\Models\QuestLocation::class;

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
    public function store(StoreQuestLocation $request, Quest $quest)
    {
        return $this->crudStore($request, $quest);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest, QuestLocation $questLocation)
    {
        return $this->crudEdit($quest, $questLocation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestLocation $request, Quest $quest, QuestLocation $questLocation)
    {
        return $this->crudUpdate($request, $quest, $questLocation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestLocation  $questLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quest $quest, QuestLocation $questLocation)
    {
        return $this->crudDestroy($quest, $questLocation);
    }
}
