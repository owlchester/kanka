<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\PermissionTestRequest;
use App\Http\Requests\StoreEntityPermission as Request;
use App\Http\Resources\EntityPermissionResource as Resource;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Services\Api\ApiPermissionService;

class EntityPermissionApiController extends ApiController
{
    protected ApiPermissionService $apiPermissionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiPermissionService $apiPermissionService)
    {
        $this->apiPermissionService = $apiPermissionService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->permissions);
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($permission);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        $model = $this->apiPermissionService->saveEntity($request, $entity);

        return Resource::collection($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $permission->update($request->only('access', 'action'));

        return new Resource($permission);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $permission->delete();

        return response()->json(null, 204);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(PermissionTestRequest $request, Campaign $campaign)
    {
        $permissionTest = $this->apiPermissionService->entityPermissionTest($request, $campaign);

        return response()->json($permissionTest);
    }
}
