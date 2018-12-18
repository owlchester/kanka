<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\StoreCalendar;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Tag;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Response;
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
            [
                'field' => 'tag_id',
                'label' => trans('crud.fields.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  trans('crud.placeholders.tag'),
                'model' => Tag::class,
            ],
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


    public function event(Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $ajax = request()->ajax();
        list($year, $month, $day) = explode('-', request()->get('date'));

        return view('calendars.events.' . ($ajax ? '_' : null) . 'create', compact(
            'calendar',
            'day',
            'month',
            'year',
            'ajax'
        ));
    }

    /**
     * @param Request $request
     * @param Calendar $calendar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eventStore(AddCalendarEvent $request, Calendar $calendar)
    {
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
        return Response::json($calendar->months());
    }
}
