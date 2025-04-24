<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\SearchService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * LiveController constructor.
     */
    public function __construct(protected SearchService $searchService) {}

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

    /**
     * Live Search
     */
    public function months(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');

        return response()->json(
            $this->searchService
                ->term($term)
                ->campaign($campaign)
                ->monthList()
        );
    }
}
