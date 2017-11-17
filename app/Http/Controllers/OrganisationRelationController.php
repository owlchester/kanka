<?php

namespace App\Http\Controllers;

use App\Organisation;
use App\Models\OrganisationRelation;
use App\Http\Requests\StoreOrganisation;
use App\Http\Requests\StoreOrganisationRelation;
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
    protected $route = 'organisations.organisation_relations';

    /**
     * @var string
     */
    protected $model = \App\Models\OrganisationRelation::class;

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function index(Organisation $organisation)
    {
        return $this->crudIndex($organisation);
    }

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
    public function store(StoreOrganisationRelation $request, Organisation $organisation)
    {
        return $this->crudStore($request, $organisation);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organisation  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation, OrganisationRelation $organisationRelation)
    {
        return $this->crudEdit($organisation, $organisationRelation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organisation  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisationRelation $request, Organisation $organisation, OrganisationRelation $organisationRelation)
    {
        return $this->crudUpdate($request, $organisation, $organisationRelation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganisationRelation  $organisationRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation, OrganisationRelation $organisationRelation)
    {
        return $this->crudDestroy($organisation, $organisationRelation);
    }
}
