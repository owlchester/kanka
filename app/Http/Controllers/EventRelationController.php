<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'events.relations';

    /**
     * @var string
     */
    protected $route = 'events.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return $this->crudCreate($event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Event $event)
    {
        return $this->crudStore($request, $event);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event, Relation $relation)
    {
        return $this->crudEdit($event, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Event $event, Relation $relation)
    {
        return $this->crudUpdate($request, $event, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $eventRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, Relation $relation)
    {
        return $this->crudDestroy($event, $relation);
    }
}
