<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
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
        $term = request()->term;
        $term2 = null;
        /** @var ?Entity $entity */
        $entity = Entity::where(['name' => request()->term, 'campaign_id' => $campaign->id])->first();
        if ($entity) {
            $term2 = $entity->type() . ':' . $entity->id;
        }

        $results = $this->service
            ->campaign($campaign)
            ->search($term, $term2);
        return $results;
    }
}
