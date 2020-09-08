<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CalendarWeather;
use App\Models\Campaign;
use App\Models\Calendar;
use App\Http\Requests\AddCalendarWeather as Request;
use App\Http\Resources\CalendarWeatherResource as Resource;

class CalendarWeatherApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($calendar
            ->calendarWeather()
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @param CalendarWeather $calendarWeather
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar);
        return new Resource($calendarWeather);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar);
        $data = $request->all();
        $data['calendar_id'] = $calendar->id;
        $model = CalendarWeather::create($data);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @param CalendarWeather $calendarWeather
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar);
        $calendarWeather->update($request->all());

        return new Resource($calendarWeather);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @param CalendarWeather $calendarWeather
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar);
        $calendarWeather->delete();

        return response()->json(null, 204);
    }
}
