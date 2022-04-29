<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CalendarFilter;
use App\Facades\Datagrid;
use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Services\CalendarService;
use App\Traits\TreeControllerTrait;
use Illuminate\Http\Request;
use Response;

class CalendarController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'calendars';
    protected $route = 'calendars';
    protected $module = 'calendars';

    protected $calendarService;

    /** @var string */
    protected $model = \App\Models\Calendar::class;

    /** @var string */
    protected $filter = CalendarFilter::class;

    /**
     * CalendarController constructor.
     * @param CalendarService $calendarService
     */
    public function __construct(CalendarService $calendarService)
    {
        parent::__construct();
        $this->calendarService = $calendarService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalendar $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        return $this->crudShow($calendar);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        return $this->crudEdit($calendar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCalendar $request, Calendar $calendar)
    {
        return $this->crudUpdate($request, $calendar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        return $this->crudDestroy($calendar);
    }


    public function event(Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $ajax = request()->ajax();
        $date = request()->get('date');
        list($year, $month, $day) = explode('-', $date);
        if (substr($date, 0, 1) == '-') {
            list($year, $month, $day) = explode('-', trim($date, '-'));
            $year = -$year;
        }


        return view('calendars.events.create', compact(
            'calendar',
            'day',
            'month',
            'year',
            'ajax',
        ));
    }

    /**
     * @param Request $request
     * @param Calendar $calendar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eventStore(AddCalendarEvent $request, Calendar $calendar)
    {
        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // We need to handle negative year dates (start with -)
        $link = $this->calendarService->addEvent($calendar, $request->all());

        $routeOptions = [$calendar->id, 'year' => request()->post('year')];
        if (request()->has('layout')) {
            $routeOptions['layout'] = 'year';
        } else {
            $routeOptions['month'] = request()->post('month');
        }

        if ($link !== false) {
            return redirect()->route($this->route . '.show', $routeOptions)
                ->with('success', trans('calendars.event.success', ['event' => $link->entity->name]));
        }

        return redirect()->route($this->route . '.show', $routeOptions)
            ->with('success', trans('calendars.event.create.success'));
    }

    /**
     * @param Calendar $calendar
     * @return mixed
     */
    public function monthList(Calendar $calendar)
    {
        return Response::json([
            'months' => $calendar->months(),
            'current' => [
                'year' => $calendar->currentDate('year'),
                'month' => $calendar->currentDate('month'),
                'day' => $calendar->currentDate('date')
            ],
            'recurring' => $calendar->recurringOptions(true),
        ]);
    }

    /**
     * @param Calendar $calendar
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function events(Calendar $calendar)
    {
        $this->authCheck($calendar);

        $options = ['calendar' => $calendar];
        $after = $before = false;
        if (request()->has('before_id')) {
            $options['before_id'] = 1;
            $before = true;
        } elseif (request()->has('after_id')) {
            $options['after_id'] = 1;
            $after = true;
        }

        Datagrid::layout(\App\Renderers\Layouts\Calendar\Reminder::class)
            ->route('calendars.events', $options)
            ->permissions(!(auth()->check() && auth()->user()->can('update', $calendar)));

        $rows = $calendar->calendarEvents();
        if ($after) {
            $rows->after($calendar);
        } elseif ($before) {
            $rows->before($calendar);
        }

        $this->rows = $rows
            ->with(['entity', 'calendar', 'entity.image'])
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($calendar, 'events');
    }

    /**
     * Set the date as today
     * @param Calendar $calendar
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function today(Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $date = request()->get('date', null);
        if ($date) {
            $calendar->update([
                'date' => $date
            ]);
        }

        return redirect()->back()
            ->with('success', trans('calendars.edit.today'));
    }
}
