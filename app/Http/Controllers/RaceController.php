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
    protected string $view = 'races';
    protected string $route = 'races';
    protected $module = 'races';

    /** @var string Model */
    protected $model = \App\Models\Race::class;

    /** @var string Filter */
    protected $filter = RaceFilter::class;

    /**
     * @param StoreRace $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRace $request)
    {
        return $this->crudStore($request);
    }

    /**
     */
    public function show(Race $race)
    {
        return $this->crudShow($race);
    }

    /**
     */
    public function edit(Race $race)
    {
        return $this->crudEdit($race);
    }

    /**
     */
    public function update(StoreRace $request, Race $race)
    {
        return $this->crudUpdate($request, $race);
    }

    /**
     */
    public function destroy(Race $race)
    {
        return $this->crudDestroy($race);
    }

    /**
     */
    public function characters(Race $race)
    {
        $this->authCheck($race);

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
            ->with([
                'location', 'location.entity',
                'families', 'families.entity',
                'races', 'races.entity',
                'entity', 'entity.tags', 'entity.image'
            ])
            ->has('entity')
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($race, 'characters');
    }

    /**
     */
    public function races(Race $race)
    {
        $this->authCheck($race);

        Datagrid::layout(\App\Renderers\Layouts\Race\Race::class)
            ->route('races.races', [$race]);

        // @phpstan-ignore-next-line
        $this->rows = $race
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'characters'])
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($race, 'races');
    }
}
