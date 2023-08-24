<?php

namespace App\Http\Controllers\Api\v1\Calendars;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Campaign;
use App\Models\Calendar;
use App\Services\Calendars\AdvancerService;
use App\Http\Requests\StoreCalendar as Request;
use App\Http\Resources\CalendarResource as Resource;

class AdvancerApiController extends ApiController
{
    protected AdvancerService $service;

    public function __construct(AdvancerService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return Resource
     */
    public function advance(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar);
        $this->service->calendar($calendar)->advance();

        return response()->json(['date' => $calendar->date]);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return Resource
     */
    public function retreat(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar);
        $this->service->calendar($calendar)->retreat();

        return response()->json(['date' => $calendar->date]);
    }
}
