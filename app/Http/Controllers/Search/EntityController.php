<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\SearchService;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    protected SearchService $search;

    /**
     * LiveController constructor.
     */
    public function __construct(SearchService $searchService)
    {
        $this->search = $searchService;
    }

    /**
     * Only find calendar entities
     */
    public function calendars(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q);

        return response()->json(
            $this->search
                ->term($term)
                ->campaign($campaign)
                ->only([config('entities.ids.calendar')])
                ->find()
        );
    }
}
