<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationRelation;
use App\Http\Requests\StoreLocation;
use App\Http\Requests\StoreLocationRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'locations.relations';
    
    /**
     * @var string
     */
    protected $route = 'locations.location_relations';


    /**
     * @var string
     */
    protected $model = \App\Models\LocationRelation::class;

    /**
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function index(Location $location)
    {
        return $this->crudIndex($location);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Location $location)
    {
        return $this->crudCreate($location);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRelation $request, Location $location)
    {
        return $this->crudStore($request, $location);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location, LocationRelation $locationRelation)
    {
        return $this->crudEdit($location, $locationRelation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocationRelation $request, Location $location, LocationRelation $locationRelation)
    {
        return $this->crudUpdate($request, $location, $locationRelation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationRelation  $locationRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, LocationRelation $locationRelation)
    {
        return $this->crudDestroy($location, $locationRelation);
    }
}
