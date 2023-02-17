<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CalendarFilter;
use App\Facades\Datagrid;
use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Services\CalendarService;
use App\Traits\TreeControllerTrait;

class CalendarController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'calendars';
    protected string $route = 'calendars';
    protected $module = 'calendars';

    protected CalendarService $calendarService;

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
     * Store the new calendar in the db
     */
    public function store(StoreCalendar $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Calendar $calendar)
    {
        return $this->campaign($campaign)->crudShow($calendar);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Calendar $calendar)
    {
        return $this->campaign($campaign)->crudEdit($calendar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCalendar $request, Campaign $campaign, Calendar $calendar)
    {
        return $this->campaign($campaign)->crudUpdate($request, $calendar);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Calendar $calendar)
    {
        return $this->campaign($campaign)->crudDestroy($calendar);
    }

    public function event(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $date = request()->get('date');
        list($year, $month, $day) = explode('-', $date);
        if (str_starts_with($date, '-')) {
            list($year, $month, $day) = explode('-', trim($date, '-'));
            $year = "-{$year}";
        }

        return view('calendars.events.create', compact(
            'campaign',
            'calendar',
            'day',
            'month',
            'year',
        ));
    }

    /**
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
        if ($request->has('layout')) {
            $routeOptions['layout'] = $request->get('layout');
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
     */
    public function monthList(Calendar $calendar)
    {
        return response()->json([
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
     */
    public function events(Campaign $campaign, Calendar $calendar)
    {
        $this->authCheck($calendar);

        $options = ['campaign' => $campaign, 'calendar' => $calendar];
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
            ->has('entity')
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($calendar, 'events');
    }

    /**
     * Set the day as today
     */
    public function today(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $date = request()->get('date', null);
        if ($date) {
            $calendar->update([
                'date' => $date
            ]);
        }

        return redirect()->back()
            ->with('success', __('calendars.edit.today'));
    }
}
