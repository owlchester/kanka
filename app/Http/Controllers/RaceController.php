<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\RaceFilter;
use App\Datagrids\Sorters\RaceCharacterSorter;
use App\Datagrids\Sorters\RaceRaceSorter;
use App\Http\Requests\StoreRace;
use App\Models\Race;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;

class RaceController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'races';
    protected $route = 'races';

    /** @var string Model */
    protected $model = \App\Models\Race::class;

    /** @var string Filter */
    protected $filter = RaceFilter::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRace $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Race $race)
    {
        return $this->crudShow($race);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race)
    {
        return $this->crudEdit($race);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRace $request, Race $race)
    {
        return $this->crudUpdate($request, $race);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Race $race)
    {
        return $this->crudDestroy($race);
    }

    /**
     * @param Race $race
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function characters(Race $race)
    {
        return $this
            ->datagridSorter(RaceCharacterSorter::class)
            ->menuView($race, 'characters');
    }

    /**
     * @param Race $race
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function races(Race $race)
    {
        return $this
            ->datagridSorter(RaceRaceSorter::class)
            ->menuView($race, 'races');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Race $race)
    {
        return $this->menuView($race, 'map-points', true);
    }
}
