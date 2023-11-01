<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\CharacterFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreCharacter;
use App\Models\Campaign;
use App\Models\Character;

class CharacterController extends CrudController
{
    /**
     */
    protected string $view = 'characters';
    protected string $route = 'characters';
    protected $module = 'characters';

    /**
     * @var string
     */
    protected $model = \App\Models\Character::class;

    /**
     */
    protected string $filter = CharacterFilter::class;

    public function store(StoreCharacter $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudShow($character);
    }

    /**
     */
    public function edit(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudEdit($character);
    }

    /**
     */
    public function update(StoreCharacter $request, Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudUpdate($request, $character);
    }

    /**
     */
    public function destroy(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudDestroy($character);
    }
}
