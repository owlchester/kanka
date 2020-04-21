<?php

namespace App\Http\Controllers;

use App\Datagrids\Bulks\AbilityBulk;
use App\Datagrids\Filters\AbilityFilter;
use App\Datagrids\Sorters\AbilityAbilitySorter;
use App\Models\Character;
use App\Http\Requests\StoreAbility;
use App\Models\Ability;
use App\Traits\TreeControllerTrait;

class AbilityController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'abilities';
    protected $route = 'abilities';

    /**
     * Crud models
     */
    protected $model = \App\Models\Ability::class;

    /** @var string Filter */
    protected $filter = AbilityFilter::class;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbility $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $ability
     * @return \Illuminate\Http\Response
     */
    public function show(Ability $ability)
    {
        return $this->crudShow($ability);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ability $ability
     * @return \Illuminate\Http\Response
     */
    public function edit(Ability $ability)
    {
        return $this->crudEdit($ability);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ability $ability
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAbility $request, Ability $ability)
    {
        return $this->crudUpdate($request, $ability);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $ability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ability $ability)
    {
        return $this->crudDestroy($ability);
    }

    /**
     * @param Ability $ability
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function abilities(Ability $ability)
    {
        return $this->datagridSorter(AbilityAbilitySorter::class)
            ->menuView($ability, 'abilities');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Ability $ability)
    {
        return $this->menuView($ability, 'map-points', true);
    }
}
