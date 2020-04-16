<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\QuestFilter;
use App\Datagrids\Sorters\QuestCharacterSorter;
use App\Datagrids\Sorters\QuestItemSorter;
use App\Datagrids\Sorters\QuestLocationSorter;
use App\Datagrids\Sorters\QuestOrganisationSorter;
use App\Http\Requests\StoreQuest;
use App\Models\Character;
use App\Models\Quest;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;
use Illuminate\Http\Request;

class QuestController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'quests';
    protected $route = 'quests';

    /** @var string Model */
    protected $model = \App\Models\Quest::class;

    /** @var string Filter */
    protected $filter = QuestFilter::class;

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
        return $this
            ->datagridSorter(QuestCharacterSorter::class)
            ->menuView($quest, 'characters');
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function locations(Quest $quest)
    {
        return $this
            ->datagridSorter(QuestLocationSorter::class)
            ->menuView($quest, 'locations');
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function items(Quest $quest)
    {
        return $this
            ->datagridSorter(QuestItemSorter::class)
            ->menuView($quest, 'items');
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function organisations(Quest $quest)
    {
        return $this
            ->datagridSorter(QuestOrganisationSorter::class)
            ->menuView($quest, 'organisations');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Quest $quest)
    {
        return $this->menuView($quest, 'map-points', true);
    }
}
