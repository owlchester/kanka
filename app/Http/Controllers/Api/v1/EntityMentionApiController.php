<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityMentionResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EntityMentionApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->mentions()->paginate());
    }
}
