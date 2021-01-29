<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\EventFilter;
use App\Datagrids\Sorters\EventEventSorter;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mapPoints(Event $event)
    {
        return $this->menuView($event, 'map-points', true);
    }

    /**
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function events(Event $event)
    {
        return $this
            ->datagridSorter(EventEventSorter::class)
            ->menuView($event, 'events');
    }
}
