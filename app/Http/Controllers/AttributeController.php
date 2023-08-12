<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Http\Requests\StoreAttribute;
use App\Models\Campaign;
use App\Models\Entity;

class AttributeController extends CrudAttributeController
{
    /**
     * @var string
     */
    protected string $view = '';

    /**
     * @var string
     */
    protected string $route = '_attributes';

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
    public function index(Campaign $campaign, Entity $entity)
    {
        dump('yo');
        $this->authorize('attributes', $entity);
        return $this->campaign($campaign)->crudIndex($entity);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Campaign $campaign, Entity $entity)
    {
        return response()->redirectToRoute('entities.attributes.index', [$campaign, $entity]);
    }

    /**
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        return $this->campaign($campaign)->crudCreate($entity, $attribute);
    }

    /**
     * @param StoreAttribute $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAttribute $request, Campaign $campaign, Entity $entity)
    {
        return $this->campaign($campaign)->crudStore($request, $entity);
    }


    /**
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        return $this->campaign($campaign)->crudEdit($entity, $attribute);
    }

    /**
     * @param StoreAttribute $request
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreAttribute $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        return $this->campaign($campaign)->crudUpdate($request, $entity, $attribute);
    }

    /**
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        return $this->campaign($campaign)->crudDestroy($entity, $attribute);
    }
}
