<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationAttribute;
use App\Http\Requests\StoreLocation;
use App\Http\Requests\StoreLocationAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationAttributeController extends CrudAttributeController
{
    /**
     * @var string
     */
    protected $view = 'locations.attributes';

    /**
     * @var string
     */
    protected $route = 'locations.location_attributes';

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
    protected $model = \App\Models\LocationAttribute::class;

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
    public function store(StoreLocationAttribute $request, Location $location)
    {
        return $this->crudStore($request, $location);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location, LocationAttribute $locationAttribute)
    {
        return $this->crudEdit($location, $locationAttribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocationAttribute $request, Location $location, LocationAttribute $locationAttribute)
    {
        return $this->crudUpdate($request, $location, $locationAttribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationAttribute  $locationAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, LocationAttribute $locationAttribute)
    {
        return $this->crudDestroy($location, $locationAttribute);
    }
}
