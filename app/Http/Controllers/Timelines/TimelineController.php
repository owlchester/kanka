<?php

namespace App\Http\Controllers\Timelines;

use App\Datagrids\Filters\TimelineFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreTimeline;
use App\Models\Timeline;

class TimelineController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'timelines';
    protected $route = 'timelines';

    /** @var string */
    protected $model = \App\Models\Timeline::class;

    /** @var string */
    protected $filter = TimelineFilter::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeline $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function show(Timeline $timeline)
    {
        return $this->crudShow($timeline);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function edit(Timeline $timeline)
    {
        return $this->crudEdit($timeline);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTimeline $request, Timeline $timeline)
    {
        return $this->crudUpdate($request, $timeline);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $timeline)
    {
        return $this->crudDestroy($timeline);
    }
}
