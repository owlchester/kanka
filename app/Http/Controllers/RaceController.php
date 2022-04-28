<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\RaceFilter;
use App\Datagrids\Sorters\RaceCharacterSorter;
use App\Datagrids\Sorters\RaceRaceSorter;
use App\Facades\Datagrid;
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
    protected $module = 'races';

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
        $this->authCheck();

        $options = ['race' => $race];
        $filters = [];
        $relation = 'allCharacters';
        if (request()->has('race_id')) {
            $options['race_id'] = (int) request()->get('race_id');
            $filters['race_id'] = $options['race_id'];
            $relation = 'characters';
        }
        Datagrid::layout(\App\Renderers\Layouts\Race\Character::class)
            ->route('races.characters', $options);

        $this->rows = $race
            ->{$relation}()
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['location', 'location.entity', 'families', 'families.entity', 'races', 'races.entity', 'entity', 'entity.tags'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($race, 'characters');
    }

    /**
     * @param Race $race
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function races(Race $race)
    {
        $this->authCheck($race);

        Datagrid::layout(\App\Renderers\Layouts\Race\Race::class)
            ->route('races.races', [$race]);

        $this->rows = $race
            ->races()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'characters'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($race, 'races');
    }
}
