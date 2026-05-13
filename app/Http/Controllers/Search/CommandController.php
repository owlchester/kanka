<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\CommandSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function __construct(protected CommandSearchService $service) {}

    public function index(Campaign $campaign, Request $request): JsonResponse
    {
        $term = mb_trim(strip_tags($request->get('q', '')));
        $mode = $request->get('mode', 'name');

        if (mb_strlen($term) < 2) {
            return response()->json(['entities' => [], 'pages' => []]);
        }

        $this->service->campaign($campaign)->user(auth()->user());

        $results = $mode === 'fulltext'
            ? $this->service->fulltext($term)
            : $this->service->name($term);

        return response()->json($results);
    }
}
