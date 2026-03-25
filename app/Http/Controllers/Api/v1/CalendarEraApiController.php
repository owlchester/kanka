<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCalendarEra as Request;
use App\Http\Resources\CalendarEraResource as Resource;
use App\Models\Calendar;
use App\Models\CalendarEra;
use App\Models\Campaign;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CalendarEraApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar->entity);

        return Resource::collection($calendar
            ->calendarEras()
            ->paginate());
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function show(Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar->entity);

        return new Resource($calendarEra);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $data = $request->all();
        $data['calendar_id'] = $calendar->id;
        $model = CalendarEra::create($data);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function update(Request $request, Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $calendarEra->update($request->all());

        return new Resource($calendarEra);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Calendar $calendar, CalendarEra $calendarEra)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $calendarEra->delete();

        return response()->json(null, 204);
    }
}
