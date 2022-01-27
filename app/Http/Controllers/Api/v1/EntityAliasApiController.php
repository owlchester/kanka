<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityAlias as Request;
use App\Http\Resources\EntityAliasResource as Resource;
use App\Models\EntityAlias;

class EntityAliasApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return Resource::collection($entity->aliases);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAlias $entityAlias
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityAlias $entityAlias)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entityAlias);
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
        $data = array_merge(['entity_id' => $entity->id], $request->all());
        $model = EntityAlias::create($data);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAlias $entityAlias
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityAlias $entityAlias)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityAlias->update($request->all());

        return new Resource($entityAlias);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAlias $entityAlias
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityAlias $entityAlias
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityAlias->delete();

        return response()->json(null, 204);
    }
}
