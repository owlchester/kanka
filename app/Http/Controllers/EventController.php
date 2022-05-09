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
    protected $view = 'events';
    protected $route = 'events';
    protected $module = 'events';

    /** @var string Model */
    protected $model = \App\Models\Event::class;

    /** @var string Filter */
    protected $filter = EventFilter::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvent $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return $this->crudShow($event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return $this->crudEdit($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEvent $request, Event $event)
    {
        return $this->crudUpdate($request, $event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
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
            ->with(['entity', 'event', 'event.entity'])
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($event, 'events');
    }
}
