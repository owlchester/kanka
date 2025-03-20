<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\TimelineFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreTimeline;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Timeline;

class TimelineController extends CrudController
{
    protected string $view = 'timelines';

    protected string $route = 'timelines';

    protected string $model = Timeline::class;

    protected string $filter = TimelineFilter::class;

    protected string $module = 'timelines';

    public function store(StoreTimeline $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Timeline $timeline)
    {
        return $this->campaign($campaign)->crudShow($timeline);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Timeline $timeline)
    {
        return $this->campaign($campaign)->crudEdit($timeline);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTimeline $request, Campaign $campaign, Timeline $timeline)
    {
        return $this->campaign($campaign)->crudUpdate($request, $timeline);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Timeline $timeline)
    {
        return $this->campaign($campaign)->crudDestroy($timeline);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.timeline'))->first();
    }
}
