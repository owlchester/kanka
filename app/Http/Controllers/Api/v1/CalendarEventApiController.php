<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\ReminderResource as Resource;
use App\Models\Calendar;
use App\Models\Campaign;

class CalendarEventApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar->entity);

        return Resource::collection($calendar
            ->calendarEvents()
            ->paginate());
    }
}
