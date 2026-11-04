<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\API\PatchEntity;
use App\Http\Requests\API\StoreEntities;
use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Services\Api\BulkEntityCreatorService;
use App\Services\Entity\EntitySaveService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EntityApiController extends ApiController
{
    public function __construct(
        protected EntitySaveService $entitySaveService,
        protected BulkEntityCreatorService $bulkEntityCreatorService,
    ) {}

    public function index(Campaign $campaign)
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
        $this->authorize('access', $campaign);

        return Resource::collection($campaign->entities()
            ->apiFilter($campaign, request()->all())
            ->lastSync(request()->get('lastSync'))
            ->orderBy('entities.id')
            ->paginate()
            ->appends(request()->except(['page', 'lastSync'])));
    }

    public function show(Campaign $campaign, Entity $entity)
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);
        $entity->loadMissing(['child', 'entityType', 'tags', 'image', 'locations']);
        if ($entity->child instanceof MiscModel) {
            $entity->child->setRelation('entity', $entity);
            $entity->child->loadMissing($entity->child->apiRelations());
        }
        $resource = new Resource($entity);

        return $resource->withMisc();
    }

    public function put(StoreEntities $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [$campaign, $entityType]);

        $entities = [];

        $this->bulkEntityCreatorService
            ->campaign($campaign)
            ->entityType($entityType)
            ->user($request->user());

        foreach ($request->validated('entities', []) as $entity) {
            $entities[] = $this->bulkEntityCreatorService
                ->data(Arr::only($entity, ['name', 'entry', 'type', 'tags', 'is_private']))
                ->create();
        }

        return Resource::collection($entities);
    }

    public function edit(PatchEntity $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        if ($entity->entityType->isStandard()) {
            return response()->json(['error' => 'Only entities of custom modules can be deleted here'], 401);
        }

        $entity->update($request->validated());

        return new Resource($entity);
    }

    public function patch(PatchEntity $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $keys = ['name', 'type', 'is_private', 'is_template', 'tooltip', 'entry', 'image_uuid', 'header_uuid'];
        if ($entity->entityType->isCustom()) {
            $keys[] = 'parent_id';
        }

        $data = $request->safe()->only($keys);

        $this->entitySaveService
            ->campaign($campaign)
            ->entity($entity->fill($data))
            ->save($data);

        return new Resource($entity);
    }

    public function destroy(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $entity);

        if ($entity->entityType->isStandard()) {
            return response()->json(['error' => 'Only entities of custom modules can be deleted here'], 401);
        }

        $entity->delete();

        return response()->json(['success'], 204);
    }
}
