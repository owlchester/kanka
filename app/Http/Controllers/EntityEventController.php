<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EntityEventController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'entity_event';
    protected $route = 'entity_event';

    protected $calendarService;

    /**
     * @var string
     */
    protected $model = \App\Models\EntityEvent::class;

    /**
     * CalendarController constructor.
     */
    public function __construct(CalendarService $calendarService)
    {
        parent::__construct();
        $this->calendarService = $calendarService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('update', $entityEvent->calendar);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $calendar = $entityEvent->calendar;
        $ajax = request()->ajax();
        $next = request()->get('next', null);

        return view('calendars.events.' . ($ajax ? '_' : null) . 'edit', compact(
            'entity',
            'entityEvent',
            'calendar',
            'name',
            'route',
            'parent',
            'ajax',
            'next'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(AddCalendarEvent $request, Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('update', $entityEvent->calendar);

        $routeOptions = [$entityEvent->calendar->id, 'year' => request()->post('year')];

        $entityEvent->setDate($request->only(['year', 'month', 'day']));
        $entityEvent->update($request->all());

        if (request()->has('layout')) {
            $routeOptions['layout'] = 'year';
        } else {
            $routeOptions['month'] = request()->post('month');
        }

        $next = request()->post('next', false);
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', $entityEvent->calendar)
                ->with('success', trans('calendars.event.edit.success'));
        }

        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', trans('calendars.event.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entity $entity, EntityEvent $entityEvent)
    {
        $this->authorize('attribute', $entity->child);
        $entityEvent->delete();
        $success = __('calendars.event.destroy', ['name' => $entityEvent->calendar->name]);

        $next = request()->post('next', false);
        if ($next == 'calendars.events') {
            return redirect()
                ->route('calendars.events', $entityEvent->calendar)
                ->with('success', $success);
        }

        // Redirect to the calendar if that's where we came from
        $previous = url()->previous();
        if (strpos($previous, '/calendars/') !== false) {
            return redirect()->route('calendars.show', [$entityEvent->calendar_id])
                ->with('success', $success);
        }

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'calendars'])
            ->with('success', $success);
    }
}
