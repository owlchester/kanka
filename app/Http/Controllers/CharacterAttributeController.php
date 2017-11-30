<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterAttribute;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreCharacterAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CharacterAttributeController extends CrudAttributeController
{
    /**
     * @var string
     */
    protected $view = 'characters.attributes';

    /**
     * @var string
     */
    protected $route = 'characters.character_attributes';

    /**
     * Redirect tab after manipulating
     * @var string
     */
    protected $tab = 'attribute';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'attributes';

    /**
     * @var string
     */
    protected $model = \App\Models\CharacterAttribute::class;

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
    public function store(StoreCharacterAttribute $request, Character $character)
    {
        return $this->crudStore($request, $character);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character, CharacterAttribute $characterAttribute)
    {
        return $this->crudEdit($character, $characterAttribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCharacterAttribute $request, Character $character, CharacterAttribute $characterAttribute)
    {
        return $this->crudUpdate($request, $character, $characterAttribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CharacterAttribute  $characterAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character, CharacterAttribute $characterAttribute)
    {
        return $this->crudDestroy($character, $characterAttribute);
    }
}
