<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Attribute;

class CrudAttributeController extends Controller
{
    /**
     * @var string
     */

    protected $tab = 'attributes';

    protected $view = 'attributes';

    protected $route = '';

    protected $type = '';
    /**
     * @var Model
     */
    protected $model = \App\Models\Attribute::class;

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
    public function crudIndex(Entity $base)
    {
        $attributes = $base->attributes->paginate();
        $name = $this->view;
        $route = $entity->type . $this->route;

        return view($this->view . '.index', compact('attributes', 'name', 'route'));
    }

    /**
     * @param Model $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudCreate(Entity $entity, Attribute $attribute)
    {
        $this->authorize('create', $attribute);
        $name = $this->view;
        $route = $entity->type . $this->route;
        dd($entity);
        return view('cruds.attributes.create', compact(
            'attribute',
            'name',
            'route',
            'entity'
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
            ->route($parent . '.show', [$model->id, 'tab' => 'relations'])
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

        return redirect()->route($parent . '.show', [$model->id, 'tab' => 'relations'])
            ->with('success', trans('relations.edit.success', ['name' => $model->name]));
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
            ->route($parent . '.show', [$model->id, 'tab' => 'relations'])
            ->with('success', trans('relations.destroy.success', ['name' => $model->name]));
    }
}
