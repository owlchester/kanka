<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\AbilityFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreAbilityEntity;
use App\Http\Requests\StoreAbility;
use App\Models\Ability;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbility $request)
    {
        return $this->crudStore($request);
    }

    /**
     */
    public function show(Ability $ability)
    {
        return $this->crudShow($ability);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ability $ability)
    {
        return $this->crudEdit($ability);
    }

    /**
     */
    public function update(StoreAbility $request, Ability $ability)
    {
        return $this->crudUpdate($request, $ability);
    }

    /**
     */
    public function destroy(Ability $ability)
    {
        return $this->crudDestroy($ability);
    }

    /**
     */
    public function abilities(Ability $ability)
    {
        $this->authCheck($ability);

        $options = ['ability' => $ability];
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
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'entity.image', 'ability', 'ability.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($ability, 'abilities');
    }

    /**
     */
    public function entities(Ability $ability)
    {
        $this->authCheck($ability);

        Datagrid::layout(\App\Renderers\Layouts\Ability\Entity::class)
            ->route('abilities.entities', [$ability]);

        $this->rows = $ability
            ->entities()
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return view('abilities.entities')
            ->with('model', $ability)
            ->with('rows', $this->rows);
    }

    /**
     */
    public function entityAdd(Ability $ability)
    {
        $this->authorize('update', $ability);
        $ajax = request()->ajax();
        $formOptions = ['abilities.entity-add.save', 'ability' => $ability];
        if (request()->has('from-children')) {
            $formOptions['from-children'] = true;
        }

        return view('abilities.entities.create', [
            'model' => $ability,
            'ajax' => $ajax,
            'formOptions' => $formOptions
        ]);
    }

    /**
     */
    public function entityStore(StoreAbilityEntity $request, Ability $ability)
    {
        $this->authorize('update', $ability);
        $redirectUrlOptions = ['ability' => $ability->id];
        if (request()->has('from-children')) {
            $redirectUrlOptions['ability_id'] = $ability->id;
        }

        $ability->attachEntity($request->only('entity_id', 'visibility_id'));
        return redirect()->route('abilities.entities', ['ability' => $ability->id])
            ->with('success', trans('abilities.children.create.success', ['name' => $ability->name]));
    }
}
