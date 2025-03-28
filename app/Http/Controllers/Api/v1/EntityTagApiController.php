<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreEntityTag as Request;
use App\Http\Resources\Api\EntityTagResource as ApiResource;
use App\Http\Resources\EntityTagResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityTag;

class EntityTagApiController extends ApiController
{
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->tags()->withPivot('id')->paginate());
    }

    public function show(Campaign $campaign, Entity $entity, EntityTag $entityTag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new ApiResource($entityTag);
    }

    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->only(['tag_id']);
        $data['entity_id'] = $entity->id;
        $model = EntityTag::create($data);

        return new ApiResource($model);
    }

    public function update(Request $request, Campaign $campaign, Entity $entity, EntityTag $entityTag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityTag->update($request->all());

        return new ApiResource($entityTag);
    }

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
