<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestOrganisation;
use App\Http\Requests\StoreQuestOrganisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestOrganisationController extends QuestForeignController
{
    /**
     * @var string
     */
    protected $view = 'quests.organisations';

    /**
     * @var string
     */
    protected $route = 'quests.quest_organisations';

    /**
     * Redirect tab after manipulating
     * @var string
     */
    protected $tab = 'organisation';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'attributes';

    /**
     * @var string
     */
    protected $model = \App\Models\QuestOrganisation::class;

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
    public function store(StoreQuestOrganisation $request, Quest $quest)
    {
        return $this->crudStore($request, $quest);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest, QuestOrganisation $questOrganisation)
    {
        return $this->crudEdit($quest, $questOrganisation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestOrganisation $request, Quest $quest, QuestOrganisation $questOrganisation)
    {
        return $this->crudUpdate($request, $quest, $questOrganisation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestOrganisation  $questOrganisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quest $quest, QuestOrganisation $questOrganisation)
    {
        return $this->crudDestroy($quest, $questOrganisation);
    }
}
