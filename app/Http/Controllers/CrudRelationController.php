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
        $this->authorize('show', $base->child);

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
        $this->authorize('relation', [$model, 'add']);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $ajax = request()->ajax();

        return view('cruds.relations.create', compact(
            'model',
            'name',
            'route',
            'parent',
            'ajax'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, Model $model)
    {
        $this->authorize('relation', [$model, 'add']);

        $relation = new $this->model;
        $relation->create($request->all());

        $parent = explode('.', $this->view)[0];

        return redirect()
            ->route($parent . '.show', [$model->id, '#relations'])
            ->with('success', trans('relations.create.success', ['name' => $model->name]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $model, Model $relation)
    {
        $this->authorize('relation', [$model, 'edit']);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $ajax = request()->ajax();

        return view('cruds.relations.edit', compact(
            'model',
            'relation',
            'name',
            'route',
            'parent',
            'ajax'
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
        $this->authorize('relation', [$model, 'edit']);

        $relation->update($request->all());
        $parent = explode('.', $this->view)[0];

        return redirect()->route($parent . '.show', [$model->id, '#relations'])
            ->with('success', trans('relations.edit.success', ['name' => $model->name]));
    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudDestroy(Model $model, Model $relation)
    {
        $this->authorize('relation', [$model, 'delete']);

        $relation->delete();
        $parent = explode('.', $this->view)[0];

        return redirect()
            ->route($parent . '.show', [$model->id, '#relations'])
            ->with('success', trans('relations.destroy.success', ['name' => $model->name]));
    }
}
