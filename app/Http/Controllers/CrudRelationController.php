<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CrudRelationController extends Controller
{
    /**
     * @var string
     */
    protected $view = '';

    protected $route = '';

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crudIndex(Model $base)
    {
        $models = $base->relationships->paginate();
        $name = $this->view;
        $route = $this->route;

        return view($this->view . '.index', compact('models', 'name', 'route'));
    }

    /**
     * @param Model $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudCreate(Model $model)
    {
        $this->authorize('create', $this->model);
        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];

        return view('cruds.relations.create', compact(
            'model',
            'name',
            'route',
            'parent'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, Model $model)
    {
        $this->authorize('create', $this->model);

        $relation = new $this->model;
        $relation->create($request->all());

        $parent = explode('.', $this->view)[0];

        return redirect()
            ->route($parent . '.show', [$model->id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $model, Model $relation)
    {
        $this->authorize('update', $relation);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];

        return view('cruds.relations.edit', compact(
            'model',
            'relation',
            'name',
            'route',
            'parent'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudUpdate(Request $request, Model $model, Model $relation)
    {
        $this->authorize('update', $relation);

        $relation->update($request->all());
        $parent = explode('.', $this->view)[0];

        return redirect()->route($parent . '.show', [$model->id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudDestroy(Model $model, Model $relation)
    {
        $this->authorize('delete', $relation);

        $relation->delete();
        $parent = explode('.', $this->view)[0];

        return redirect()
            ->route($parent . '.show', [$model->id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
