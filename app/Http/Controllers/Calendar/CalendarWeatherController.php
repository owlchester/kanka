<?php

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

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index(Campaign $campaign, Calendar $calendar)
    {
        return redirect()->route('entities.show', [$campaign, $calendar->entity]);
    }

    public function create(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar);

        $date = request()->get('date');
        list($year, $month, $day) = explode('-', $date);
        if (str_starts_with($date, '-')) {
            list($year, $month, $day) = explode('-', mb_trim($date, '-'));
            $year = '-' . $year;
        }

        $weather = $this->calendarService
            ->calendar($calendar)
            ->findWeather((int) $year, (int) $month, (int) $day);

        return view('calendars.weather.' . (!empty($weather) ? 'edit' : 'create'), compact(
            'calendar',
            'campaign',
            'day',
            'month',
            'year',
            'weather'
        ));
    }

    public function store(AddCalendarWeather $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $weather = $this->calendarService
            ->calendar($calendar)
            ->saveWeather($request);

        $routeOptions = [$campaign, $calendar->entity, 'year' => $weather->year, 'month' => $weather->month];
        if ($request->has('layout')) {
            $routeOptions['layout'] = $request->get('layout');
        }
        return redirect()->route('entities.show', $routeOptions)
            ->with('success', __('calendars/weather.create.success'));
    }

    public function update(AddCalendarWeather $request, Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('update', $calendar);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $weather = $this->calendarService
            ->calendar($calendar)
            ->saveWeather($request);

        $routeOptions = [$campaign, $calendar->entity, 'year' => $weather->year, 'month' => $weather->month];
        if ($request->has('layout')) {
            $routeOptions['layout'] = $request->get('layout');
        }

        return redirect()->route('entities.show', $routeOptions)
            ->with('success', __('calendars/weather.edit.success'));
    }

    public function destroy(Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('update', $calendar);
        $calendarWeather->delete();

        $routeOptions = [$campaign, $calendar->entity];
        if (request()->has('layout')) {
            $routeOptions['layout'] = request()->get('layout');
        }

        return redirect()->route('entities.show', $routeOptions)
            ->with('success', __('calendars/weather.destroy.success'));
    }
}
