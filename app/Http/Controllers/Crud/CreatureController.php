<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\CreatureFilter;
use App\Facades\Datagrid;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreCreature;
use App\Models\Campaign;
use App\Models\Creature;
use App\Traits\TreeControllerTrait;

class CreatureController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'creatures';
    protected string $route = 'creatures';
    protected $module = 'creatures';

    /** @var string Model */
    protected $model = \App\Models\Creature::class;

    /** @var string Filter */
    protected $filter = CreatureFilter::class;

    /**
     * @param StoreCreature $request
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

    /**
     */
    public function creatures(Campaign $campaign, Creature $creature)
    {
        $this->authCheck($creature);

        $options = ['creature' => $creature];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $creature->id;
            $filters['creature_id'] = $creature->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Creature\Creature::class)
            ->route('creatures.creatures', $options);

        // @phpstan-ignore-next-line
        $this->rows = $creature
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with(['entity'])
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->menuView($creature, 'creatures');
    }
}
