<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Resources\EntityResource as Resource;
use App\Services\Search\EntitySearchService;

class FullTextSearchApiController extends ApiController
{
    protected EntitySearchService $service;

    public function __construct(EntitySearchService $service)
    {
        $this->service = $service;
    }

    /**
     * return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $results = $this->service->campaign($campaign)->search(request()->term);
        //dd($results);
        return $results;

        return Resource::collection($campaign->entities()->whereIn('id', $results)
            ->paginate()
            ->appends(request()->except(['page', 'lastSync'])));

    }
}
