<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreOrganisation;
use App\Http\Requests\StoreLocation;
use App\Models\Location;
use App\Models\Organisation;
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
    protected $model = \App\Models\Organisation::class;

    /**
     * OrganisationController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
            [
                'field' => 'location_id',
                'label' => trans('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  trans('crud.placeholders.location'),
                'model' => Location::class,
            ]
        ];
    }

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
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return $this->crudShow($organisation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organisation $organisation
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
     * @param  \App\Models\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisation $request, Organisation $organisation)
    {
        return $this->crudUpdate($request, $organisation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        return $this->crudDestroy($organisation);
    }
}
