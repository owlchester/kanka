<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\LocationFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreLocation;
use App\Models\Campaign;
use App\Models\Location;
use App\Traits\TreeControllerTrait;

class LocationController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'locations';
    protected string $route = 'locations';
    protected $module = 'locations';

    /** @var string Model */
    protected $model = \App\Models\Location::class;

    /** @var string Filter */
    protected $filter = LocationFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocation $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Location $location)
    {
        return $this->campaign($campaign)->crudShow($location);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Location $location)
    {
        return $this->campaign($campaign)->crudEdit($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLocation $request, Campaign $campaign, Location $location)
    {
        return $this->campaign($campaign)->crudUpdate($request, $location);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Location $location)
    {
        return $this->campaign($campaign)->crudDestroy($location);
    }
}
