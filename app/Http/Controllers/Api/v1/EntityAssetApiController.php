<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\EntityAssetType;
use App\Http\Requests\StoreEntityAsset as Request;
use App\Http\Resources\EntityAssetResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Services\EntityFileService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EntityAssetApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->assets()->with(['entity', 'image'])->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($entityAsset);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;

        if ($request->get('type_id') == EntityAssetType::file->value) {
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
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityAsset->update($request->all());

        return new Resource($entityAsset);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
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
