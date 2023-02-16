<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\LocationFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreLocation;
use App\Models\Campaign;
use App\Models\Location;
use App\Traits\TreeControllerTrait;

class LocationController extends CrudController
{
    /**
     * Tree / Nested Mode
     */
    use TreeControllerTrait;

    protected $treeControllerParentKey = 'parent_location_id';

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
    public function store(StoreLocation $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return $this->crudShow($location);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return $this->crudEdit($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLocation $request, Location $location)
    {
        return $this->crudUpdate($request, $location);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        return $this->crudDestroy($location);
    }

    /**
     * @param Location $location
     */
    public function characters(Campaign $campaign, Location $location)
    {
        $this->authCheck($location);

        $options = ['campaign' => $campaign, 'location' => $location];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $location->id;
            $filters['location_id'] = $location->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Location\Character::class)
            ->route('locations.characters', $options);

        $this->rows = $location
            ->allCharacters()
            ->select(['id', 'image', 'name', 'title', 'type','location_id', 'is_dead', 'is_private'])
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['location', 'location.entity', 'families', 'families.entity', 'races', 'races.entity', 'entity', 'entity.tags', 'entity.image'])
            ->has('entity')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($location, 'characters');
    }

    /**
     * @param Location $location
     */
    public function locations(Campaign $campaign, Location $location)
    {
        $this->authCheck($location);

        $options = ['campaign' => $campaign, 'location' => $location];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $location->id;
            $filters['parent_location_id'] = $location->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Location\Location::class)
            ->route('locations.locations', $options);

        // @phpstan-ignore-next-line
        $this->rows = $location
            ->descendants()
            ->select(['id', 'image', 'name', 'type', 'parent_location_id', 'is_private'])
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['location', 'location.entity', 'entity', 'entity.tags', 'entity.image'])
            ->has('entity')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($location, 'locations');
    }
}
