<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\EntityType;
use App\Services\Api\FilterService;

class FilterApiController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index()
    {
        return response()->json($this->filterService->endpoints());
    }

    public function show(EntityType $entityType)
    {
        return response()->json([
            'data' => $this->filterService
                ->entityType($entityType)
                ->filters(),
        ]);
    }
}
