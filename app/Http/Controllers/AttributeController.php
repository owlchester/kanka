<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Attribute;
use App\Http\Requests\StoreAttribute;
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
}
