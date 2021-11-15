<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\QuestFilter;
use App\Http\Requests\StoreQuest;
use App\Models\Quest;
use App\Traits\TreeControllerTrait;

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
}
