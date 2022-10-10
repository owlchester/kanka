<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityAsset as Request;
use App\Http\Resources\EntityAssetResource as Resource;
use App\Models\EntityAsset;

class EntityAssetApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return Resource::collection($entity->assets);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAsset $entityAsset
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entityAsset);
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
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $model = EntityAsset::create($data);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAsset $entityAsset
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityAsset->update($request->all());

        return new Resource($entityAsset);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityAsset $entityAsset
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityAsset $entityAsset
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityAsset->delete();

        return response()->json(null, 204);
    }
}
