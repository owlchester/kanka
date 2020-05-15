<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StoreEntityFile as Request;
use App\Http\Resources\EntityFileResource as Resource;
use App\Models\EntityFile;

class EntityFileApiController extends ApiController
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
        return Resource::collection($entity->files);
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($entityFile);
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
        $model = EntityFile::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityFile $entityFile)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityFile->update($request->all());

        return new Resource($entityFile);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param EntityFile $entityFile
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityFile $entityFile
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $entityFile->delete();

        return response()->json(null, 204);
    }
}
