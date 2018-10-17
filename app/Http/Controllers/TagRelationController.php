<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'tags.relations';

    /**
     * @var string
     */
    protected $route = 'tags.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tag $tag)
    {
        return $this->crudCreate($tag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Tag $tag)
    {
        return $this->crudStore($request, $tag);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag, Relation $relation)
    {
        return $this->crudEdit($tag, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Tag $tag, Relation $relation)
    {
        return $this->crudUpdate($request, $tag, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $tagRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag, Relation $relation)
    {
        return $this->crudDestroy($tag, $relation);
    }
}
