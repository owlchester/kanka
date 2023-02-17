<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CreatureFilter;
use App\Facades\Datagrid;
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
    public function store(StoreCreature $request, Campaign $campaign)
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
    public function update(StoreCreature $request, Campaign $campaign, Creature $creature)
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

        $options = ['campaign' => $campaign, 'creature' => $creature];
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
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['entity'])
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($creature, 'creatures');
    }
}
