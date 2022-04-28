<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\AbilityFilter;
use App\Datagrids\Sorters\AbilityAbilitySorter;
use App\Datagrids\Sorters\AbilityEntitySorter;
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
    protected $view = 'abilities';
    protected $route = 'abilities';
    protected $module = 'abilities';

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
     *
     * @param StoreAbility $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAbility $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $ability
     * @return \Illuminate\Http\Response
     */
    public function show(Ability $ability)
    {
        return $this->crudShow($ability);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ability $ability
     * @return \Illuminate\Http\Response
     */
    public function edit(Ability $ability)
    {
        return $this->crudEdit($ability);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ability $ability
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAbility $request, Ability $ability)
    {
        return $this->crudUpdate($request, $ability);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $ability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ability $ability)
    {
        return $this->crudDestroy($ability);
    }

    /**
     * @param Ability $ability
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function abilities(Ability $ability)
    {
        Datagrid::layout(\App\Renderers\Layouts\Ability\Ability::class)
            ->route('abilities.abilities', [$ability]);

        $this->rows = $ability
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'ability', 'ability.entity'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            $html = view('layouts.datagrid._table')->with('rows', $this->rows)->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'url' => request()->fullUrl()
            ]);
        }

        return $this
            ->menuView($ability, 'abilities');
    }

    /**
     * @param Ability $ability
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function entities(Ability $ability)
    {
        Datagrid::layout(\App\Renderers\Layouts\Ability\Entity::class)
            ->route('abilities.entities', [$ability]);

        $this->rows = $ability
            ->entities()
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            $html = view('layouts.datagrid._table')->with('rows', $this->rows)->render();
            return response()->json([
                'success' => true,
                'html' => $html,
                'url' => request()->fullUrl()
            ]);
        }

        return view('abilities.entities')
            ->with('model', $ability)
            ->with('rows', $this->rows);
    }

    /**
     * @param Ability $ability
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param StoreAbilityEntity $request
     * @param Ability $ability
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function entityStore(StoreAbilityEntity $request, Ability $ability)
    {
        $this->authorize('update', $ability);
        $redirectUrlOptions = ['ability' => $ability->id];
        if (request()->has('from-children')) {
            $redirectUrlOptions['ability_id'] = $ability->id;
        }

        $ability->attachEntity($request->only('entity_id', 'visibility'));
        return redirect()->route('abilities.entities', ['ability' => $ability->id])
            ->with('success', trans('abilities.children.create.success', ['name' => $ability->name]));
    }
}
