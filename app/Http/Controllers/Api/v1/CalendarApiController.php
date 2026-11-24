<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCalendar;
use App\Http\Resources\CalendarResource;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Sanitizers\CalendarSanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CalendarApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->calendars(), CalendarResource::class);
    }

    public function show(Campaign $campaign, Calendar $calendar): CalendarResource
    {
        return new CalendarResource($this->viewModel($campaign, $calendar));
    }

    public function store(StoreCalendar $request, Campaign $campaign): CalendarResource
    {
        return new CalendarResource($this->storeModel($request, $campaign, config('entities.ids.calendar')));
    }

    public function update(StoreCalendar $request, Campaign $campaign, Calendar $calendar): CalendarResource
    {
        return new CalendarResource($this->updateModel($request, $campaign, $calendar));
    }

    public function destroy(Campaign $campaign, Calendar $calendar): JsonResponse
    {
        return $this->deleteModel($campaign, $calendar);
    }

    protected function childData(FormRequest $request, array $validated): array
    {
        return array_replace($validated, app(CalendarSanitizer::class)->request($request)->sanitize());
    }
}
