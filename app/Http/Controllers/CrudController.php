<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    /**
     * The view where to find the resources
     *
     * @var string
     */
    protected $view = '';

    /**
     * The name of the route for the resource
     *
     * @var string
     */
    protected $route = '';

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * Extra actions in the index view
     *
     * @var array
     */
    protected $indexActions = [];

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
    public function index(Request $request)
    {
        return $this->crudIndex($request);
    }
    public function crudIndex(Request $request)
    {
        $model = new $this->model;
        $name = $this->view;
        $actions = $this->indexActions;


        $models = $model
            ->search(request()
                ->get('search'))
            ->order(request()->get('order'), request()->has('desc'))
            ->paginate();
        return view('cruds.index', compact('models', 'name', 'model', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->crudCreate();
    }
    public function crudCreate($params = [])
    {
        $this->authorize('create', $this->model);

        return view('cruds.create', array_merge(['name' => $this->view], $params));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param bool $redirectToCreated
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, $redirectToCreated = false)
    {
        $this->authorize('create', $this->model);

        $model = new $this->model;
        $new = $model->create($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->route . '.create')
                ->with('success', trans($this->view . '.create.success', ['name' => $new->name]));
        }

        if ($redirectToCreated) {
            return redirect()->route($this->route . '.show', $new)
                ->with('success', trans($this->view . '.create.success', ['name' => $new->name]));
        }
        return redirect()->route($this->route . '.index')
            ->with('success_raw', trans($this->view . '.create.success', ['name' =>
                link_to_route($this->route . '.show', e($new->name), $new)]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudShow(Model $model)
    {
        $this->authorize('view', $model);
        $name = $this->view;

        // Fix for models without an entity
        if (empty($model->entity)) {
            $model->save();
            $model->load('entity');
        }

        return view('cruds.show', compact('model', 'name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $model)
    {
        $this->authorize('update', $model);
        $name = $this->view;

        return view('cruds.edit', compact('model', 'name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudUpdate(Request $request, Model $model)
    {
        $this->authorize('update', $model);

        $model->update($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->route . '.create')
            ->with('success_raw', trans($this->view . '.edit.success', ['name' =>
                link_to_route($this->route . '.show', e($model->name), $model)]));
        }
        return redirect()->route($this->route . '.show', $model->id)
            ->with('success_raw', trans($this->view . '.edit.success', ['name' =>
                link_to_route($this->route . '.show', e($model->name), $model)]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudDestroy(Model $model)
    {
        $this->authorize('delete', $model);

        $model->delete();
        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->view . '.destroy.success', ['name' => $model->name]));
    }

    /**
     * Multiple delete of a model
     *
     * @param Request $request
     */
    public function deleteMany(Request $request)
    {
        $model = new $this->model;

        $ids = $request->get('model');

        $count = 0;
        foreach ($ids as $id) {
            $entity = $model->findOrFail($id);
            if ($this->authorize('delete', $entity)) {
                $entity->delete();
                $count++;
            }
        }

        return redirect()->route($this->route . '.index')
            ->with('success', trans_choice('crud.destroy_many.success', $count,['count' => $count]));
    }
}
