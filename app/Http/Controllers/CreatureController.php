<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CreatureFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreCreature;
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
    public function store(StoreCreature $request)
    {
        return $this->crudStore($request);
    }

    /**
     */
    public function show(Creature $creature)
    {
        return $this->crudShow($creature);
    }

    /**
     */
    public function edit(Creature $creature)
    {
        return $this->crudEdit($creature);
    }

    /**
     */
    public function update(StoreCreature $request, Creature $creature)
    {
        return $this->crudUpdate($request, $creature);
    }

    /**
     */
    public function destroy(Creature $creature)
    {
        return $this->crudDestroy($creature);
    }

    /**
     */
    public function creatures(Creature $creature)
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
