<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\LocationFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreLocation;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Location;
use App\Models\MiscModel;
use App\Services\Entity\Relations\LocationRelationsService;

class LocationController extends CrudController
{
    protected string $view = 'locations';

    protected string $route = 'locations';

    protected string $module = 'locations';

    protected string $model = Location::class;

    protected string $filter = LocationFilter::class;

    public function __construct(protected LocationRelationsService $locationRelationsService) {}

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

    protected function afterModelSave(MiscModel $model, array $data): void
    {
        $this->locationRelationsService->save($model, $data);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.location'))->first();
    }
}
