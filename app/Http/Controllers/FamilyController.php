<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreLocation;
use App\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FamilyController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'families';
    protected $route = 'families';

    /**
     * @var string
     */
    protected $model = \App\Family::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFamily $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $family
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        return $this->crudShow($family);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $family)
    {
        return $this->crudEdit($family);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFamily $request, Family $family)
    {
        return $this->crudUpdate($request, $family);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        return $this->crudDestroy($family);
    }
}
