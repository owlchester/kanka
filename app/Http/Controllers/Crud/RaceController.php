<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\RaceFilter;
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
    protected string $filter = RaceFilter::class;

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
}
