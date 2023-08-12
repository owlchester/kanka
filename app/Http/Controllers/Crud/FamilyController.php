<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\FamilyFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreFamily;
use App\Models\Campaign;
use App\Models\Family;
use App\Traits\TreeControllerTrait;

class FamilyController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'families';
    protected string $route = 'families';
    protected $module = 'families';

    /**
     * Crud models
     */
    protected $model = \App\Models\Family::class;

    /** @var string Filter */
    protected string $filter = FamilyFilter::class;

    public function store(StoreFamily $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudShow($family);
    }

    public function edit(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudEdit($family);
    }

    public function update(StoreFamily $request, Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudUpdate($request, $family);
    }

    public function destroy(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudDestroy($family);
    }
}
