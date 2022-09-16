<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CharacterFilter;
use App\Models\Character;
use App\Http\Requests\StoreCharacter;

class CharacterController extends CrudController
{
    /**
     * @var string
     */
    protected string $view = 'characters';
    protected string $route = 'characters';
    protected $module = 'characters';

    /**
     * @var string
     */
    protected $model = \App\Models\Character::class;

    /**
     * @var string
     */
    protected $filter = CharacterFilter::class;

    public function store(StoreCharacter $request)
    {
        return $this->crudStore($request);
    }

    /**
     * @param Character $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        return $this->crudShow($character);
    }

    /**
     * @param Character $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        return $this->crudEdit($character);
    }

    /**
     * @param StoreCharacter $request
     * @param Character $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCharacter $request, Character $character)
    {
        return $this->crudUpdate($request, $character);
    }

    /**
     * @param Character $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
        return $this->crudDestroy($character);
    }
}
