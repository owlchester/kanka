<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\NameLookupService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct(protected NameLookupService $searchService) {}

    public function index(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');

        return response()->json(
            $this->searchService
                ->term($term)
                ->campaign($campaign)
                ->only(config('entities.ids.calendar'))
                ->find()
        );
    }

    public function months(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');
        $results = [];

        $calendars = $campaign->calendars()->withWhereHas('entity')->get();
        foreach ($calendars as $calendar) {
            foreach ($calendar->months ?? [] as $month) {
                if (! str_contains($month['name'], $term)) {
                    continue;
                }

                $results[] = [
                    'fullname' => $month['name'],
                    'name' => $month['name'] . ' (' . $calendar->entity->name . ')',
                ];
            }
        }

        return response()->json($results);
    }
}
