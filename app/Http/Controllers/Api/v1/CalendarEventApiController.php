<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\EntityEvent;
use App\Models\Campaign;
use App\Models\Calendar;
use App\Http\Resources\EntityEventResource as Resource;

class CalendarEventApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar);
        return Resource::collection($calendar
            ->calendarEvents()
            ->paginate());
    }
}
