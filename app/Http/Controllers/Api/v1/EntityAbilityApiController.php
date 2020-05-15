<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityAbility as Request;
use App\Http\Resources\EntityAbilityResource as Resource;
use App\Models\EntityAbility;

class EntityAbilityApiController extends ApiController
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
        return Resource::collection($entity->abilities);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entityAbility);
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
        $model = EntityAbility::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityAbility->update($request->all());

        return new Resource($entityAbility);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityAbility $entityAbility
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityAbility->delete();

        return response()->json(null, 204);
    }
}
