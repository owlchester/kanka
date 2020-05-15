<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreInventory as Request;
use App\Http\Resources\InventoryResource as Resource;
use App\Models\Inventory;

class EntityInventoryApiController extends ApiController
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
        return Resource::collection($entity->inventories);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Inventory $inventory
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($inventory);
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
        $model = Inventory::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Inventory $inventory
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $inventory->update($request->all());

        return new Resource($inventory);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Inventory $inventory
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
        $this->authorize('update', $entity->child);
        $inventory->delete();

        return response()->json(null, 204);
    }
}
