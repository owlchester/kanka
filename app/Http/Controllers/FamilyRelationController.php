<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FamilyRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'families.relations';

    /**
     * @var string
     */
    protected $route = 'families.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Family $family)
    {
        return $this->crudCreate($family);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Family $family)
    {
        return $this->crudStore($request, $family);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $family, Relation $relation)
    {
        return $this->crudEdit($family, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Family $family, Relation $relation)
    {
        return $this->crudUpdate($request, $family, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $familyRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family, Relation $relation)
    {
        return $this->crudDestroy($family, $relation);
    }
}
