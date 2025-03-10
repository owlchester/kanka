<?php

namespace App\Http\Controllers\Api\v1\Calendars;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Campaign;
use App\Models\Calendar;
use App\Services\Calendars\AdvancerService;

class AdvancerApiController extends ApiController
{
    protected AdvancerService $service;

    public function __construct(AdvancerService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function advance(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        if ($calendar->missingDetails()) {
            return response()->json(['Invalid calendar config'], 406);
        }
        $this->service->calendar($calendar)->advance();

        return response()->json(['date' => $calendar->date]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function retreat(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        if ($calendar->missingDetails()) {
            return response()->json(['Invalid calendar config'], 406);
        }
        $this->service->calendar($calendar)->retreat();

        return response()->json(['date' => $calendar->date]);
    }
}
