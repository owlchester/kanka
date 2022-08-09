<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityPermission as Request;
use App\Http\Resources\EntityPermissionResource as Resource;
use App\Models\CampaignPermission;
use App\Services\Api\ApiPermissionService;

class EntityPermissionApiController extends ApiController
{
    /**
     *
     * @var ApiPermissionService
     */
    protected $apiPermissionService;

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
     * @return Collection
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
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);

        $this->apiPermissionService->saveEntity($request, $entity);
        //$model = CampaignPermission::create($request->all());
        return  response()->json('Permissions successfully created.');
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
        $permission->update($request->all());

        return new Resource($permission);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param CampaignPermission $permission
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Entity $entity, CampaignPermission $permission)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $permission->delete();

        return response()->json(null, 204);
    }
}
