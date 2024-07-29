<?php

namespace App\Http\Controllers\Api\v1\Entities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Entities\SlimEntityResource;
use App\Models\Campaign;
use App\Services\PaginationService;

class SlimController extends Controller
{
    public function __construct(PaginationService $paginationService)
    {
        $this->paginationService = $paginationService;
    }
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->paginationService->

        return SlimEntityResource::collection($campaign->entities()
            ->apiFilter(request()->all())
            ->lastSync(request()->get('lastSync'))
            ->paginate()
            ->appends(request()->except(['page', 'lastSync'])));
    }
}
