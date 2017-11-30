<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'quests.relations';

    /**
     * @var string
     */
    protected $route = 'quests.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

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
    public function store(StoreRelation $request, Quest $quest)
    {
        return $this->crudStore($request, $quest);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quest  $quest
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest, Relation $relation)
    {
        return $this->crudEdit($quest, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quest  $quest
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Quest $quest, Relation $relation)
    {
        return $this->crudUpdate($request, $quest, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $questRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quest $quest, Relation $relation)
    {
        return $this->crudDestroy($quest, $relation);
    }
}
