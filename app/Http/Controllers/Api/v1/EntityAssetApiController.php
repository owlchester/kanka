<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityAsset as Request;
use App\Http\Resources\EntityAssetResource as Resource;
use App\Models\EntityAsset;
use App\Services\EntityFileService;

class EntityAssetApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return Resource::collection($entity->assets()->with(['entity', 'image'])->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entityAsset);
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

        if ($request->get('type_id') == EntityAsset::TYPE_FILE) {
            /** @var EntityFileService $service */
            $service = app()->make(EntityFileService::class);
            $files = $service
                ->entity($entity)
                ->campaign($campaign)
                ->upload($request, 'file')
                ->files();
            return new Resource($files[0]);
        }
        $model = EntityAsset::create($data);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityAsset->update($request->all());

        return new Resource($entityAsset);
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
        EntityAsset $entityAsset
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityAsset->delete();

        return response()->json(null, 204);
    }
}
