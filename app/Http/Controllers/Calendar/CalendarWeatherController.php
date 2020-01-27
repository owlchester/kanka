<?php
/**
 * Description of
 *
 * @author Ilestis
 * 20/01/2020
 */

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCalendarWeather;
use App\Models\Calendar;
use App\Models\CalendarWeather;
use App\Services\CalendarService;

class CalendarWeatherController extends Controller
{
    /**
     * @var CalendarService
     */
    protected $calendarService;

    /**
     * CalendarWeatherController constructor.
     * @param CalendarService $calendarService
     */
    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * @param Calendar $calendar
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $ajax = request()->ajax();
        $date = request()->get('date');
        list($year, $month, $day) = explode('-', $date);
        if (substr($date, 0, 1) == '-') {
            list($year, $month, $day) = explode('-', trim($date, '-'));
            $year = -$year;
        }

        $weather = $this->calendarService->findWeather($calendar, $year, $month, $day);

        return view('calendars.weather.' . (!empty($weather) ? 'edit' : 'create'), compact(
            'calendar',
            'day',
            'month',
            'year',
            'ajax',
            'weather'
        ));
    }

    /**
     * @param AddCalendarWeather $request
     * @param Calendar $calendar
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AddCalendarWeather $request, Calendar $calendar)
    {
        $this->authorize('update', $calendar);
        $weather = $this->calendarService->saveWeather($calendar, $request);

        $routeOptions = [$calendar->id, 'year' => $weather->year, 'month' => $weather->month];
        if ($request->has('layout')) {
            $routeOptions['layout'] = 'year';
        }
        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', __('calendars/weather.create.success'));
    }

    public function update(AddCalendarWeather $request, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('update', $calendar);

        $weather = $this->calendarService->saveWeather($calendar, $request);
        $routeOptions = [$calendar->id, 'year' => $weather->year, 'month' => $weather->month];

        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', __('calendars/weather.edit.success'));
    }

    /**
     * @param Calendar $calendar
     * @param CalendarWeather $calendarWeather
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('update', $calendar);
        $calendarWeather->delete();

        return redirect()->route('calendars.show', $calendar)
            ->with('success', __('calendars/weather.destroy.success'));
    }
}
