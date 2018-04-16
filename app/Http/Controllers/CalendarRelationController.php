<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CalendarRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'calendars.relations';

    /**
     * @var string
     */
    protected $route = 'calendars.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Calendar $calendar)
    {
        return $this->crudCreate($calendar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Calendar $calendar)
    {
        return $this->crudStore($request, $calendar);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar, Relation $relation)
    {
        return $this->crudEdit($calendar, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Calendar $calendar, Relation $relation)
    {
        return $this->crudUpdate($request, $calendar, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $calendarRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar, Relation $relation)
    {
        return $this->crudDestroy($calendar, $relation);
    }
}
