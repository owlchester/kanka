<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\EventFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreEvent;
use App\Models\Campaign;
use App\Models\Event;
use App\Traits\TreeControllerTrait;

class EventController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'events';
    protected string $route = 'events';
    protected $module = 'events';

    /** @var string Model */
    protected $model = \App\Models\Event::class;

    /** @var string Filter */
    protected $filter = EventFilter::class;

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

    /**
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function events(Campaign $campaign, Event $event)
    {
        $this->authCheck($event);

        $options = ['campaign' => $campaign, 'event' => $event];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $event->id;
            $filters['event_id'] = $event->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Event\Event::class)
            ->route('events.events', $options);

        // @phpstan-ignore-next-line
        $this->rows = $event
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'entity.image', 'event', 'event.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($event, 'events');
    }
}
