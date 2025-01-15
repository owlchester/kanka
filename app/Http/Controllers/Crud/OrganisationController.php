<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\OrganisationFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreOrganisation;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Organisation;

class OrganisationController extends CrudController
{
    protected string $view = 'organisations';
    protected string $route = 'organisations';
    protected string $module = 'organisations';

    protected string $model = Organisation::class;

    protected string $filter = OrganisationFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganisation $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Organisation $organisation)
    {
        return $this->campaign($campaign)->crudShow($organisation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Organisation $organisation)
    {
        return $this->campaign($campaign)->crudEdit($organisation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrganisation $request, Campaign $campaign, Organisation $organisation)
    {
        return $this->campaign($campaign)->crudUpdate($request, $organisation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Organisation $organisation)
    {
        return $this->campaign($campaign)->crudDestroy($organisation);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.organisation'))->first();
    }
}
