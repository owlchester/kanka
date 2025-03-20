<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\FamilyFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreFamily;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Family;

class FamilyController extends CrudController
{
    protected string $view = 'families';

    protected string $route = 'families';

    protected string $module = 'families';

    protected string $model = Family::class;

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

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.family'))->first();
    }
}
