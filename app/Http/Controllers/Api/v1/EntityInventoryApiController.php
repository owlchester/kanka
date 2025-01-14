<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\UpdateInventory as Request;
use App\Http\Resources\InventoryResource as Resource;
use App\Models\Inventory;

class EntityInventoryApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);
        return Resource::collection($entity->inventories()->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);
        return new Resource($inventory);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $model = Inventory::create($data);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $inventory->update($request->all());

        return new Resource($inventory);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        Inventory $inventory
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $inventory->delete();

        return response()->json(null, 204);
    }
}
