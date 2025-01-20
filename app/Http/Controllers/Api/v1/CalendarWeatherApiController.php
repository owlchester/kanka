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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar->entity);
        return new Resource($calendarWeather);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $data = $request->all();
        $data['calendar_id'] = $calendar->id;
        $model = CalendarWeather::create($data);
        return new Resource($model);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $calendarWeather->update($request->all());

        return new Resource($calendarWeather);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Calendar $calendar, CalendarWeather $calendarWeather)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $calendarWeather->delete();

        return response()->json(null, 204);
    }
}
