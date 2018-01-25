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
     * @var Entity
     */
    protected $model = \App\Entitys\Attribute::class;

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
    public function crudIndex(Entity $entity)
    {
        $attributes = $entity->attributes->paginate();
        $name = $this->view;
        $route = $entity->type . $this->route;

        return view($this->view . '.index', compact('attributes', 'name', 'route'));
    }

    /**
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudCreate(Entity $entity, Attribute $attribute)
    {
        $this->authorize('create', $attribute);
        $name = $entity->pluralType() . '.attributes' . $this->view;
        $route = 'entities.attributes';
        $parentRoute = $entity->pluralType();
        return view('cruds.attributes.create', compact(
            'attribute',
            'name',
            'route',
            'entity',
            'parentRoute'
        ));
    }

    /**
     * @param Entity $entity
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, Entity $entity)
    {
        $this->authorize('create', $entity->child);

        $attribute = new Attribute();
        $attribute->entity_id = $entity->id;
        $attribute->create($request->all());

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'attribute'])
            ->with('success', trans('attributes.create.success', ['name' => $entity->child->name]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entitys\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Entity $entity, Attribute $model)
    {
        $this->authorize('update', $model);

        $name = $entity->pluralType() . '.attributes' . $this->view;
        $route = 'entities.attributes';
        $parentRoute = $entity->pluralType();

        return view('cruds.attributes.edit', compact(
            'entity',
            'model',
            'name',
            'route',
            'parentRoute'
        ));
    }

    /**
     * @param Request $request
     * @param Entity $model
     * @param Entity $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudUpdate(Request $request, Entity $entity, Attribute $attribute)
    {
        $this->authorize('update', $entity->child);

        $attribute->update($request->all());

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'attribute'])
            ->with('success', trans('attributes.edit.success', ['name' => $entity->name]));
    }

    /**
     * @param Entity $model
     * @param Entity $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudDestroy(Entity $entity, Attribute $attribute)
    {
        $this->authorize('delete', $attribute);

        $attribute->delete();

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'attribute'])
            ->with('success', trans('attributes.destroy.success', ['name' => $entity->name]));
    }
}
