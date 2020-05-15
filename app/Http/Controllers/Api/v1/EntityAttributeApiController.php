<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreAttribute as Request;
use App\Http\Resources\AttributeResource as Resource;
use App\Models\Attribute;

class EntityAttributeApiController extends ApiController
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
        return Resource::collection($entity->attributes);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Attribute $attribute
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($attribute);
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
        $model = Attribute::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Attribute $attribute
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $attribute->update($request->all());

        return new Resource($attribute);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $attribute->delete();

        return response()->json(null, 204);
    }
}
