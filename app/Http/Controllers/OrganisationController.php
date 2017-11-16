<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreOrganisation;
use App\Http\Requests\StoreLocation;
use App\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrganisationController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'organisations';
    protected $route = 'organisations';

    /**
     * @var string
     */
    protected $model = \App\Organisation::class;


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganisation $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return $this->crudShow($organisation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation)
    {
        return $this->crudEdit($organisation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisation $request, Organisation $organisation)
    {
        return $this->crudUpdate($request, $organisation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        return $this->crudDestroy($organisation);
    }
}
