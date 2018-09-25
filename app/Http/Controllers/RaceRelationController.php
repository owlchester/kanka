<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RaceRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'races.relations';

    /**
     * @var string
     */
    protected $route = 'races.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Race $race)
    {
        return $this->crudCreate($race);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Race $race)
    {
        return $this->crudStore($request, $race);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race, Relation $relation)
    {
        return $this->crudEdit($race, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Race $race, Relation $relation)
    {
        return $this->crudUpdate($request, $race, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $raceRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Race $race, Relation $relation)
    {
        return $this->crudDestroy($race, $relation);
    }
}
