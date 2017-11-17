<?php

namespace App\Http\Controllers;

use App\Family;
use App\FamilyRelation;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreFamilyRelation;
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
    protected $route = 'families.family_relations';

    /**
     * @var string
     */
    protected $model = \App\FamilyRelation::class;

    /**
     * @param Family $family
     * @return \Illuminate\Http\Response
     */
    public function index(Family $family)
    {
        return $this->crudIndex($family);
    }

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
    public function store(StoreFamilyRelation $request, Family $family)
    {
        return $this->crudStore($request, $family);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $family, FamilyRelation $familyRelation)
    {
        return $this->crudEdit($family, $familyRelation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFamilyRelation $request, Family $family, FamilyRelation $familyRelation)
    {
        return $this->crudUpdate($request, $family, $familyRelation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FamilyRelation  $familyRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family, FamilyRelation $familyRelation)
    {
        return $this->crudDestroy($family, $familyRelation);
    }
}
