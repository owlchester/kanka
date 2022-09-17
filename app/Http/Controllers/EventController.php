<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\EventFilter;
use App\Datagrids\Sorters\EventEventSorter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreEvent;
use App\Models\Event;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function store(StoreEvent $request)
    {
        return $this->crudStore($request);
    }

    public function show(Event $event)
    {
        return $this->crudShow($event);
    }

    public function edit(Event $event)
    {
        return $this->crudEdit($event);
    }

    public function update(StoreEvent $request, Event $event)
    {
        return $this->crudUpdate($request, $event);
    }

    public function destroy(Event $event)
    {
        return $this->crudDestroy($event);
    }

    /**
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function events(Event $event)
    {
        $this->authCheck($event);

        Datagrid::layout(\App\Renderers\Layouts\Event\Event::class)
            ->route('events.events', [$event]);

        $this->rows = $event
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'entity.image', 'event', 'event.entity'])
            ->has('entity')
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($event, 'events');
    }
}
