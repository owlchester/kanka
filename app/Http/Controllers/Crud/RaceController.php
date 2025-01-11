<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\RaceFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreRace;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Race;

class RaceController extends CrudController
{
    protected string $view = 'races';
    protected string $route = 'races';
    protected string $module = 'races';

    protected string $model = Race::class;

    protected string $filter = RaceFilter::class;

    /**
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

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.race'))->first();
    }
}
