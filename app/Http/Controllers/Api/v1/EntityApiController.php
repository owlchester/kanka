<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Resources\EntityResource as Resource;
use App\Models\EntityEvent;

class EntityApiController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign->entities);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entity);
    }
}
