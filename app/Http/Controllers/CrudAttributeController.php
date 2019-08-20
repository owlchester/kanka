<?php

namespace App\Http\Controllers;

use App\Services\AttributeService;
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
    protected $model = \App\Models\Attribute::class;

    /**
     * @var AttributeService
     */
    protected $attributeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AttributeService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->attributeService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crudIndex(Entity $entity)
    {
        $this->authorize('browse', [$entity->child]);

        $attributes = $entity->attributes()->paginate();
        $name = $this->view;
        $route = $entity->type . $this->route;
        $parentRoute = $entity->pluralType();

        $existing = count($entity->attributes);

        return view('cruds.attributes.index', compact(
            'attributes',
            'name',
            'route',
            'entity',
            'parentRoute',
            'existing'
        ));
    }

    /**
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudCreate(Entity $entity, Attribute $attribute)
    {
        $this->authorize('attribute', [$entity->child, 'add']);

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
        $this->authorize('attribute', [$entity->child, 'add']);

        $attribute = new Attribute();
        $attribute->entity_id = $entity->id;
        $attribute = $attribute->create($request->all());

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id, '#attribute'])
            ->with('success', trans('crud.attributes.create.success', [
                'name' => $attribute->name, 'entity' => $entity->child->name
            ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entitys\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Entity $entity, Attribute $model)
    {
        $this->authorize('attribute', [$entity->child, 'edit']);

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
        $this->authorize('attribute', [$entity->child, 'edit']);

        $attribute->update($request->all());

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, '#attribute'])
            ->with('success', trans('crud.attributes.edit.success', [
                'name' => $attribute->name, 'entity' => $entity->name
            ]));
    }

    /**
     * @param Entity $model
     * @param Entity $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudDestroy(Entity $entity, Attribute $attribute)
    {
        $this->authorize('attribute', [$entity->child, 'delete']);

        $attribute->delete();

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id, '#attribute'])
            ->with('success', trans('crud.attributes.destroy.success', [
                'name' => $attribute->name, 'entity' => $entity->name
            ]));
    }

    /**
     * Save many attributes at the same time
     *
     * @param Entity $entity
     */
    public function saveMany(Entity $entity)
    {
        $this->authorize('attribute', [$entity->child, 'edit']);

        $data = request()->only(
            'attr_name',
            'attr_value',
            'attr_is_private',
            'attr_is_star',
            'attr_type',
            'template_id'
        );
        $this->attributeService->saveEntity($data, $entity);

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, '#attribute'])
            ->with('success', trans('crud.attributes.index.success', ['entity' => $entity->name]));
    }
}
