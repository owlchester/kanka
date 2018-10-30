<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Calendar;
use App\Http\Requests\StoreCalendar as Request;
use App\Http\Resources\Calendar as Resource;
use App\Http\Resources\CalendarCollection as Collection;

class CalendarApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return new Collection($campaign->calendars()->acl()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return Resource
     */
    public function show(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar);
        return new Resource($calendar);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Calendar::class);
        $model = Calendar::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar);
        $calendar->update($request->all());

        return new Resource($calendar);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $calendar);
        $calendar->delete();

        return response()->json(null, 204);
    }
}
