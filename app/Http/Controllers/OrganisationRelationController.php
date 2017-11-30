<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrganisationRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'organisations.relations';

    /**
     * @var string
     */
    protected $route = 'organisations.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organisation $organisation)
    {
        return $this->crudCreate($organisation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Organisation $organisation)
    {
        return $this->crudStore($request, $organisation);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation, Relation $relation)
    {
        return $this->crudEdit($organisation, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Organisation $organisation, Relation $relation)
    {
        return $this->crudUpdate($request, $organisation, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $organisationRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation, Relation $relation)
    {
        return $this->crudDestroy($organisation, $relation);
    }
}
