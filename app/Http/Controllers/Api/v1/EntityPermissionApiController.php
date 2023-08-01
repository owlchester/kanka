<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityPermission as Request;
use App\Http\Requests\PermissionTestRequest;
use App\Http\Resources\EntityPermissionResource as Resource;
use App\Models\CampaignPermission;
use App\Services\Api\ApiPermissionService;

class EntityPermissionApiController extends ApiController
{
    protected ApiPermissionService $apiPermissionService;

    /**
     * Create a new controller instance.
     *
     * @param  ApiPermissionService  $apiPermissionService
     * @return void
     */
    public function __construct(ApiPermissionService $apiPermissionService)
    {
        $this->apiPermissionService = $apiPermissionService;
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return Resource::collection($entity->permissions);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param CampaignPermission $permission
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($permission);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);

        $model = $this->apiPermissionService->saveEntity($request, $entity);
        return Resource::collection($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param CampaignPermission $permission
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $permission->update($request->only('access', 'action'));

        return new Resource($permission);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param CampaignPermission $permission
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $permission->delete();

        return response()->json(null, 204);
    }

    /**
     * @param PermissionTestRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(PermissionTestRequest $request, Campaign $campaign)
    {
        $permissionTest = $this->apiPermissionService->entityPermissionTest($request, $campaign);
        return response()->json($permissionTest);
    }
}
