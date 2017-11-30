<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CrudAttributeController extends Controller
{
    /**
     * @var string
     */
    protected $view = '';

    /**
     * @var string
     */
    protected $route = '';

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * Redirect tab after manipulating
     * @var string
     */
    protected $tab = 'attribute';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'attributes';


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
//        $models = $base->attributes->paginate();
//        $name = $this->view;
//        $route = $this->route;
//
//        return view($this->view . '.index', compact('models', 'name', 'route'));
    }

    /**
     * @param Model $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudCreate(Model $parent)
    {
        $this->authorize('create', $this->model);
        $name = $this->view;
        $route = $this->route;
        $tab = $this->tab;
        $parentRoute = explode('.', $this->view)[0];

        return view('cruds.' . $this->crudView . '.create', compact(
            'parent',
            'name',
            'route',
            'parentRoute',
            'tab'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, Model $parent)
    {
        $this->authorize('create', $this->model);

        $newModel = new $this->model;
        $newModel->create($request->all());

        $parentRoute = explode('.', $this->view)[0];

        return redirect()
            ->route($parentRoute . '.show', [$parent->id, 'tab' => $this->tab])
            ->with('success', trans($this->view . '.create.success', ['name' => $parent->name]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $parent, Model $model)
    {
        $this->authorize('update', $model);

        $name = $this->view;
        $route = $this->route;
        $tab = $this->tab;
        $parentRoute = explode('.', $this->view)[0];

        return view('cruds.' . $this->crudView . '.edit', compact(
            'parent',
            'model',
            'name',
            'route',
            'parentRoute',
            'tab'
        ));
    }

    /**
     * @param Request $request
     * @param Model $parent
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudUpdate(Request $request, Model $parent, Model $model)
    {
        $this->authorize('update', $model);

        $model->update($request->all());
        $parentRoute = explode('.', $this->view)[0];

        return redirect()->route($parentRoute . '.show', [$parent->id, 'tab' => $this->tab])
            ->with('success', trans($this->view . '.edit.success', ['name' => $parent->name]));
    }

    /**
     * @param Model $model
     * @param Model $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudDestroy(Model $parent, Model $model)
    {
        $this->authorize('delete', $model);

        $model->delete();
        $parentRoute = explode('.', $this->view)[0];

        return redirect()
            ->route($parentRoute . '.show', [$parent->id, 'tab' => $this->tab])
            ->with('success', trans($this->view . '.destroy.success', ['name' => $parent->name]));
    }
}
