<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CharacterRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'characters.relations';

    /**
     * @var string
     */
    protected $route = 'characters.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Character $character)
    {
        return $this->crudCreate($character);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Character $character)
    {
        return $this->crudStore($request, $character);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character, Relation $relation)
    {
        return $this->crudEdit($character, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Character $character, Relation $relation)
    {
        return $this->crudUpdate($request, $character, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $characterRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character, Relation $relation)
    {
        return $this->crudDestroy($character, $relation);
    }
}
