<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\AbilityFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreAbility;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\EntityType;

class AbilityController extends CrudController
{
    protected string $view = 'abilities';
    protected string $route = 'abilities';
    protected string $module = 'abilities';

    protected string $model = Ability::class;

    protected string $filter = AbilityFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Campaign $campaign, StoreAbility $request)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudShow($ability);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudEdit($ability);
    }

    /**
     */
    public function update(StoreAbility $request, Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudUpdate($request, $ability);
    }

    /**
     */
    public function destroy(Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudDestroy($ability);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.ability'))->first();
    }
}
