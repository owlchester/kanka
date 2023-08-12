<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\AbilityFilter;
use App\Facades\Datagrid;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreAbility;
use App\Http\Requests\StoreAbilityEntity;
use App\Models\Ability;
use App\Models\Campaign;
use App\Traits\TreeControllerTrait;

class AbilityController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'abilities';
    protected string $route = 'abilities';
    protected string $module = 'abilities';

    /**
     * Crud models
     */
    protected $model = \App\Models\Ability::class;

    /** @var string Filter */
    protected $filter = AbilityFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Campaign $campaign, StoreAbility $request)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudShow($ability);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudEdit($ability);
    }

    /**
     */
    public function update(StoreAbility $request, Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudUpdate($request, $ability);
    }

    /**
     */
    public function destroy(Campaign $campaign, Ability $ability)
    {
        return $this->campaign($campaign)->crudDestroy($ability);
    }

    /**
     */
    public function abilities(Campaign $campaign, Ability $ability)
    {
        $this->authCheck($ability);

        $options = ['campaign' => $campaign, 'ability' => $ability];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $ability->id;
            $filters['ability_id'] = $ability->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Ability\Ability::class)
            ->route('abilities.abilities', $options);

        // @phpstan-ignore-next-line
        $this->rows = $ability
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['entity', 'entity.image', 'ability', 'ability.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this
                ->campaign($campaign)
                ->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->menuView($ability, 'abilities');
    }

    /**
     */
    public function entities(Campaign $campaign, Ability $ability)
    {
        $this->authCheck($ability);

        Datagrid::layout(\App\Renderers\Layouts\Ability\Entity::class)
            ->route('abilities.entities', [$campaign, $ability]);

        $this->rows = $ability
            ->entities()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this
                ->campaign($campaign)
                ->datagridAjax();
        }

        return view('abilities.entities')
            ->with('campaign', $campaign)
            ->with('model', $ability)
            ->with('rows', $this->rows);
    }

    /**
     */
    public function entityAdd(Campaign $campaign, Ability $ability)
    {
        $this->authorize('update', $ability);
        $formOptions = ['abilities.entity-add.save', $campaign, 'ability' => $ability];
        if (request()->has('from-children')) {
            $formOptions['from-children'] = true;
        }

        return view('abilities.entities.create', [
            'campaign' => $campaign,
            'model' => $ability,
            'formOptions' => $formOptions
        ]);
    }

    /**
     */
    public function entityStore(StoreAbilityEntity $request, Campaign $campaign, Ability $ability)
    {
        $this->authorize('update', $ability);
        $redirectUrlOptions = ['ability' => $ability->id];
        if (request()->has('from-children')) {
            $redirectUrlOptions['ability_id'] = $ability->id;
        }

        $ability->attachEntity($request->only('entity_id', 'visibility_id'));
        return redirect()->route('abilities.entities', [$campaign, 'ability' => $ability->id])
            ->with('success', trans('abilities.children.create.success', ['name' => $ability->name]));
    }
}
