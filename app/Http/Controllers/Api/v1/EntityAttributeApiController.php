<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreAttribute as Request;
use App\Http\Resources\AttributeResource as Resource;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;

class EntityAttributeApiController extends ApiController
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

        return Resource::collection($entity->attributes()->with('entity')->get());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($attribute);
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
        $model = Attribute::create($data);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $attribute->update($data);

        return new Resource($attribute);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $attribute->delete();

        return response()->json(null, 204);
    }
}
