<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'items.relations';

    /**
     * @var string
     */
    protected $route = 'items.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Item $item)
    {
        return $this->crudCreate($item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Item $item)
    {
        return $this->crudStore($request, $item);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item, Relation $relation)
    {
        return $this->crudEdit($item, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Item $item, Relation $relation)
    {
        return $this->crudUpdate($request, $item, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $itemRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, Relation $relation)
    {
        return $this->crudDestroy($item, $relation);
    }
}
