<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\SearchService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected SearchService $search;

    /**
     * LiveController constructor.
     */
    public function __construct(SearchService $searchService)
    {
        $this->search = $searchService;
    }

    public function index(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->get('q') ?? '');

        return response()->json(
            $this->search
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
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->monthList()
        );
    }
}
