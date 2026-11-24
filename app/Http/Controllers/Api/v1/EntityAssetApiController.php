<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\EntityAssetType;
use App\Exceptions\TranslatableException;
use App\Http\Requests\StoreEntityAsset;
use App\Http\Requests\UpdateEntityAsset;
use App\Http\Resources\EntityAssetResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Services\EntityFileService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @return resource|JsonResponse
     *
     * @throws AuthorizationException
     */
    public function store(StoreEntityAsset $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;

        if ($request->get('type_id') == EntityAssetType::file->value) {
            /** @var EntityFileService $service */
            $service = app()->make(EntityFileService::class);
            try {
                $files = $service
                    ->entity($entity)
                    ->campaign($campaign)
                    ->upload($request, 'file')
                    ->files();
            } catch (TranslatableException $exception) {
                if (! in_array($exception->getMessage(), [
                    'crud.files.errors.max',
                    'gallery.download.errors.gallery_full_free',
                    'gallery.download.errors.gallery_full_premium',
                ], true)) {
                    throw $exception;
                }

                return response()->json(['error' => $exception->getTranslatedMessage()], 422);
            }

            return new Resource($files[0]);
        }
        $model = EntityAsset::create($data);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(UpdateEntityAsset $request, Campaign $campaign, Entity $entity, EntityAsset $entityAsset)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityAsset->update($request->all());

        return new Resource($entityAsset);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(
        Request $request,
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
