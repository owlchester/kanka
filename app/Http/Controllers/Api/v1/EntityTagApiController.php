<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreEntityTag as Request;
use App\Http\Resources\EntityTagResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityTag;

class EntityTagApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->tags()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityTag $entityTag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($entityTag);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $model = EntityTag::create($data);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityTag $entityTag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityTag->update($request->all());

        return new Resource($entityTag);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityTag $entityTag
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityTag->delete();

        return response()->json(null, 204);
    }
}
