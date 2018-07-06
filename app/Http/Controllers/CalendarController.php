<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CalendarController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'calendars';
    protected $route = 'calendars';

    protected $calendarService;

    /**
     * @var string
     */
    protected $model = \App\Models\Calendar::class;

    /**
     * CalendarController constructor.
     */
    public function __construct(CalendarService $calendarService)
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
        ];

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

    /**
     * @param Request $request
     * @param Calendar $calendar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addEvent(AddCalendarEvent $request, Calendar $calendar)
    {
        // We need to handle negative year dates (start with -)
        $fullDate = request()->post('date');
        $date = explode('-', request()->post('date'));
        if (count($date) == 4 && substr($fullDate, 0, 1) === '-') {
            $date[0] = '-' . $date[1];
            $date[1] = $date[2];
            $date[2] = $date[3];
            unset($date[4]);
        }
        $link = $this->calendarService->addEvent($calendar, $request->all());

        if ($link !== false) {
            return redirect()->route($this->route . '.show', [$calendar->id, 'year' => $date[0], 'month' => $date[1]])
                ->with('success', trans('calendars.event.success', ['event' => $link->entity->name]));
        }
        return redirect()->route($this->route . '.show', [$calendar->id, 'year' => $date[0], 'month' => $date[1]]);
    }
}
