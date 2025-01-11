<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\EventFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreEvent;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Event;

class EventController extends CrudController
{
    protected string $view = 'events';
    protected string $route = 'events';
    protected string $module = 'events';

    protected string $model = Event::class;

    protected string $filter = EventFilter::class;

    public function store(StoreEvent $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Event $event)
    {
        return $this->campaign($campaign)->crudShow($event);
    }

    public function edit(Campaign $campaign, Event $event)
    {
        return $this->campaign($campaign)->crudEdit($event);
    }

    public function update(StoreEvent $request, Campaign $campaign, Event $event)
    {
        return $this->campaign($campaign)->crudUpdate($request, $event);
    }

    public function destroy(Campaign $campaign, Event $event)
    {
        return $this->campaign($campaign)->crudDestroy($event);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.event'))->first();
    }
}
