<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreRace;
use App\Models\Race;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RaceController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'races';
    protected $route = 'races';

    /**
     * @var string
     */
    protected $model = \App\Models\Race::class;

    /**
     * RaceController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRace $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Race $race)
    {
        return $this->crudShow($race);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race)
    {
        return $this->crudEdit($race);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRace $request, Race $race)
    {
        return $this->crudUpdate($request, $race);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Race $race)
    {
        return $this->crudDestroy($race);
    }

    /**
     * @param Race $race
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function characters(Race $race)
    {
        return $this->menuView($race, 'characters');
    }
}
