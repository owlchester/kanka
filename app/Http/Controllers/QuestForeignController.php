<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuestForeignController extends Controller
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
     * Redirect menu after manipulating
     * @var string
     */
    protected $menu = '';

    /**
     * Crud view path
     * @var string
     */
    protected $crudView = 'quests';


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
        $this->authorize('update', $parent);

        $name = $this->view;
        $route = $this->route;
        $tab = $this->menu;
        $parentRoute = explode('.', $this->view)[0];
        $model = new $this->model;
        $menu = $this->menu;

        return view('quests.foreign.create', compact(
            'parent',
            'model',
            'name',
            'route',
            'parentRoute',
            'menu',
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
        $this->authorize('update', $parent);

        $newModel = new $this->model;
        $newModel->create($request->all());

        $parentRoute = explode('.', $this->view)[0];

        return redirect()
            ->route('quests.' . $this->menu, $parent->id)
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
        $this->authorize('update', $parent);

        $name = $this->view;
        $route = $this->route;
        $tab = $this->menu;
        $parentRoute = explode('.', $this->view)[0];
        $menu = $this->menu;

        return view('quests.foreign.edit', compact(
            'parent',
            'model',
            'name',
            'route',
            'menu',
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
        $this->authorize('update', $parent);

        $model->update($request->all());
        $parentRoute = explode('.', $this->view)[0];

        return redirect()->route('quests.' . $this->menu, $parent->id)
            ->with('success', trans($this->view . '.edit.success', ['name' => $parent->name]));
    }

    /**
     * @param Model $model
     * @param Model $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudDestroy(Model $parent, Model $model)
    {
        $this->authorize('update', $parent);

        $model->delete();
        $parentRoute = explode('.', $this->view)[0];

        return redirect()
            ->route('quests.' . $this->menu, $parent->id)
            ->with('success', trans($this->view . '.destroy.success', ['name' => $parent->name]));
    }
}
