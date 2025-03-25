<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCalendar as Request;
use App\Http\Resources\CalendarResource as Resource;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Sanitizers\CalendarSanitizer;

class CalendarApiController extends ApiController
{
    protected CalendarSanitizer $sanitizer;

    public function __construct(CalendarSanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->calendars()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $calendar->entity);

        return new Resource($calendar);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.calendar')), $campaign]);

        $request->merge($this->sanitizer->request($request)->sanitize());
        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        /** @var Calendar $model */
        $model = Calendar::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $calendar->entity);
        $request->merge($this->sanitizer->request($request)->sanitize());
        $calendar->update($request->all());
        $this->crudSave($calendar);

        return new Resource($calendar);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $calendar->entity);
        $calendar->delete();

        return response()->json(null, 204);
    }
}
