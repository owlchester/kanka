<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\CreatureFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreCreature;
use App\Models\Campaign;
use App\Models\Creature;
use App\Models\EntityType;

class CreatureController extends CrudController
{
    protected string $view = 'creatures';
    protected string $route = 'creatures';
    protected string $module = 'creatures';

    protected string $model = Creature::class;

    protected string $filter = CreatureFilter::class;

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Campaign $campaign, StoreCreature $request)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Creature $creature)
    {
        return $this->campaign($campaign)->crudShow($creature);
    }

    /**
     */
    public function edit(Campaign $campaign, Creature $creature)
    {
        return $this->campaign($campaign)->crudEdit($creature);
    }

    /**
     */
    public function update(Campaign $campaign, StoreCreature $request, Creature $creature)
    {
        return $this->campaign($campaign)->crudUpdate($request, $creature);
    }

    /**
     */
    public function destroy(Campaign $campaign, Creature $creature)
    {
        return $this->campaign($campaign)->crudDestroy($creature);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.creature'))->first();
    }
}
