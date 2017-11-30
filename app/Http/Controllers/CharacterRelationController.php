<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterRelation;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreCharacterRelation;
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
    protected $route = 'characters.character_relations';

    /**
     * @var string
     */
    protected $model = \App\Models\CharacterRelation::class;

    /**
     * @param Character $character
     * @return \Illuminate\Http\Response
     */
    public function index(Character $character)
    {
        return $this->crudIndex($character);
    }

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
    public function store(StoreCharacterRelation $request, Character $character)
    {
        return $this->crudStore($request, $character);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character, CharacterRelation $characterRelation)
    {
        return $this->crudEdit($character, $characterRelation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCharacterRelation $request, Character $character, CharacterRelation $characterRelation)
    {
        return $this->crudUpdate($request, $character, $characterRelation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CharacterRelation  $characterRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character, CharacterRelation $characterRelation)
    {
        return $this->crudDestroy($character, $characterRelation);
    }
}
