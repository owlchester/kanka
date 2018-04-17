<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CalendarEventController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'calendar_event';
    protected $route = 'calendar_event';

    protected $calendarService;

    /**
     * @var string
     */
    protected $model = \App\Models\CalendarEvent::class;

    /**
     * CalendarController constructor.
     */
    public function __construct(CalendarService $calendarService)
    {
        parent::__construct();
        $this->calendarService = $calendarService;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEvent $calendarEvent)
    {
        $this->authorize('calendar', $calendarEvent->event);
        $calendarEvent->delete();

        return redirect()->route('events.show', [$calendarEvent->event, 'tab' => 'calendars'])
            ->with('success', trans('calendars.event.destroy', ['name' => $calendarEvent->calendar->name]));
    }
}
