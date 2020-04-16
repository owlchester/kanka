<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\AttributeTemplate;
use App\Models\Character;
use App\Models\Attribute;
use App\Http\Requests\StoreAttribute;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $this->authorize('attributes', $entity);
        return $this->crudIndex($entity);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Entity $entity)
    {
        return response()->redirectToRoute('entities.attributes.index', $entity);
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
        $this->authorize('update', $entity->child);
        $this->authorize('attributes', $entity);

        $name = $entity->pluralType() . '.attributes' . $this->view;
        $route = 'entities.attributes';
        $parentRoute = $entity->pluralType();
        $ajax = request()->ajax();
        $communityTemplates = [];
        foreach (config('attribute-templates.templates') as $code => $class) {
            $template = new $class;
            $communityTemplates[$code] = $template->name();
        }

        return view('cruds.attributes.' . ($ajax ? '_' : null) . 'template', compact(
            'communityTemplates',
            'name',
            'route',
            'entity',
            'parentRoute',
            'ajax'
        ));
    }

    public function applyTemplate(ApplyAttributeTemplate $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $templateName = $this->attributeService->apply($entity, $request->only(['template_id', 'template']));

        if (!$templateName) {
            return redirect()->back()->with('error', trans('crud.attributes.template.error'));
        }

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id, '#tab_attribute'])
            ->with('success', trans('crud.attributes.template.success', [
                'name' => $templateName, 'entity' => $entity->child->name
            ]));
    }
}
