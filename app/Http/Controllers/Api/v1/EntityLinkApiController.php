<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityLink as Request;
use App\Http\Resources\EntityLinkResource as Resource;
use App\Models\EntityLink;

class EntityLinkApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return Resource::collection($entity->links);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityLink $entityLink
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityLink $entityLink)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entityLink);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $model = EntityLink::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityLink $entityLink
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityLink $entityLink)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityLink->update($request->all());

        return new Resource($entityLink);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityLink $entityLink
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityLink $entityLink
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityLink->delete();

        return response()->json(null, 204);
    }
}
