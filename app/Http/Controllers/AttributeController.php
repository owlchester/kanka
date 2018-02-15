<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\AttributeTemplate;
use App\Models\Character;
use App\Models\Attribute;
use App\Http\Requests\StoreAttribute;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Entity;

class AttributeController extends CrudAttributeController
{
    /**
     * @var string
     */
    protected $view = '';

    /**
     * @var string
     */
    protected $route = '_attributes';

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
     * @var string
     */
    protected $model = \App\Models\Attribute::class;

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function index(Entity $entity)
    {
        return $this->crudIndex($entity);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Entity $entity, Attribute $attribute)
    {
        return $this->crudCreate($entity, $attribute);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttribute $request, Entity $entity)
    {
        return $this->crudStore($request, $entity);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Entity $entity, Attribute $attribute)
    {
        return $this->crudEdit($entity, $attribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAttribute $request, Entity $entity, Attribute $attribute)
    {
        return $this->crudUpdate($request, $entity, $attribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CharacterAttribute  $characterAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entity $entity, Attribute $attribute)
    {
        return $this->crudDestroy($entity, $attribute);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function template(Entity $entity)
    {
        $this->authorize('create', 'App\Models\Attribute');
        $name = $entity->pluralType() . '.attributes' . $this->view;
        $route = 'entities.attributes';
        $parentRoute = $entity->pluralType();
        return view('cruds.attributes.template', compact(
            'attribute',
            'name',
            'route',
            'entity',
            'parentRoute'
        ));
    }

    public function applyTemplate(ApplyAttributeTemplate $request, Entity $entity)
    {
        $this->authorize('create', $entity->child);

        // This is dirty
        $template = AttributeTemplate::findOrFail($request->get('template_id'));
        $template->apply($entity);

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'attribute'])
            ->with('success', trans('crud.attributes.template.success', ['name' => $template->name, 'entity' => $entity->child->name]));
    }
}
