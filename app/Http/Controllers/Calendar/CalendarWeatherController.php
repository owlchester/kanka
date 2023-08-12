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
use App\Models\Campaign;
use App\Services\CalendarService;

class CalendarWeatherController extends Controller
{
    protected CalendarService $calendarService;

    /**
     * CalendarWeatherController constructor.
     * @param CalendarService $calendarService
     */
    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index(Campaign $campaign, Calendar $calendar)
    {
        return redirect()->route('calendars.show', [$campaign, $calendar]);
    }

    /**
     * @param Calendar $calendar
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $date = request()->get('date');
        list($year, $month, $day) = explode('-', $date);
        if (str_starts_with($date, '-')) {
            list($year, $month, $day) = explode('-', trim($date, '-'));
            $year = '-' . $year;
        }

        $weather = $this->calendarService->findWeather($calendar, (int) $year, (int) $month, (int) $day);

        return view('calendars.weather.' . (!empty($weather) ? 'edit' : 'create'), compact(
            'calendar',
            'campaign',
            'day',
            'month',
            'year',
            'weather'
        ));
    }

    /**
     * @param AddCalendarWeather $request
     * @param Calendar $calendar
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AddCalendarWeather $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar);
        $weather = $this->calendarService->saveWeather($calendar, $request);

        $routeOptions = [$campaign, $calendar->id, 'year' => $weather->year, 'month' => $weather->month];
        if ($request->has('layout')) {
            $routeOptions['layout'] = $request->get('layout');
        }
        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', __('calendars/weather.create.success'));
    }

    public function update(AddCalendarWeather $request, Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('update', $calendar);

        $weather = $this->calendarService->saveWeather($calendar, $request);
        $routeOptions = [$campaign, $calendar->id, 'year' => $weather->year, 'month' => $weather->month];
        if ($request->has('layout')) {
            $routeOptions['layout'] = $request->get('layout');
        }

        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', __('calendars/weather.edit.success'));
    }

    /**
     * @param Calendar $calendar
     * @param CalendarWeather $calendarWeather
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('update', $calendar);
        $calendarWeather->delete();

        $routeOptions = [$campaign, $calendar];
        if (request()->has('layout')) {
            $routeOptions['layout'] = request()->get('layout');
        }

        return redirect()->route('calendars.show', $routeOptions)
            ->with('success', __('calendars/weather.destroy.success'));
    }
}
