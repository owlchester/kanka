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
use Illuminate\Support\Str;

class EntityEventController extends Controller
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
        //parent::__construct();
        $this->calendarService = $calendarService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $name = $this->view;
        $route = $this->route;
        $parent = explode('.', $this->view)[0];
        $ajax = request()->ajax();
        $next = request()->get('next', null);

        return view('calendars.events.create_from_entity', compact(
            'entity',
            'name',
            'route',
            'parent',
            'ajax',
            'next',
            'entity'
        ));
    }

    /**
     * @param AddCalendarEvent $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AddCalendarEvent $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $reminder = new EntityEvent($request->all());
        $reminder->entity_id = $entity->id;
        $reminder->save();


        $next = request()->post('next', false);
        if ($next == 'entity.events') {
            return redirect()
                ->to($entity->url('show', 'tab_calendars'))
                ->with('success', trans('calendars.event.create.success'));
        }

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->entity_id, '#calendars'])
            ->with('success', trans('calendars.event.create.success'));
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
        $from = request()->get('from', null);
        if (!empty($from)) {
            $from = Calendar::find($from);
        }

        return view('calendars.events.edit', compact(
            'entity',
            'entityEvent',
            'calendar',
            'name',
            'route',
            'parent',
            'ajax',
            'next',
            'from'
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

        $routeOptions = ['calendar' => $entityEvent->calendar->id, 'year' => request()->post('year')];
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
        } elseif ($next == 'entity.events') {
            return redirect()
                ->to($entity->url('show', 'tab_calendars'))
                ->with('success', trans('calendars.event.edit.success'));
        } elseif (Str::startsWith($next, 'calendar.')) {
            $id = Str::after($next, 'calendar.');
            $routeOptions['calendar'] = $id;
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

        } elseif ($next == 'entity.events') {
            return redirect()
                ->to($entity->url('show', 'tab_calendars'))
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
