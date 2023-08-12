<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\RaceFilter;
use App\Facades\Datagrid;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreRace;
use App\Models\Campaign;
use App\Models\Race;
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
    public function store(StoreRace $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Race $race)
    {
        return $this->campaign($campaign)->crudShow($race);
    }

    /**
     */
    public function edit(Campaign $campaign, Race $race)
    {
        return $this->campaign($campaign)->crudEdit($race);
    }

    /**
     */
    public function update(StoreRace $request, Campaign $campaign, Race $race)
    {
        return $this->campaign($campaign)->crudUpdate($request, $race);
    }

    /**
     */
    public function destroy(Campaign $campaign, Race $race)
    {
        return $this->campaign($campaign)->crudDestroy($race);
    }

    /**
     */
    public function characters(Campaign $campaign, Race $race)
    {
        $this->authCheck($race);

        $options = ['campaign' => $campaign, 'race' => $race];
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
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
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
            return $this->campaign($campaign)->datagridAjax();
        }

        return redirect()->route('races.show', $race);
    }

    /**
     */
    public function races(Campaign $campaign, Race $race)
    {
        $this->authCheck($race);

        $options = ['campaign' => $campaign, 'race' => $race];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $race->id;
            $filters['parent'] = $race->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Race\Race::class)
            ->route('races.races', $options);

        // @phpstan-ignore-next-line
        $this->rows = $race
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['entity', 'characters'])
            ->filter($filters)
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->menuView($race, 'races');
    }
}
