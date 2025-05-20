<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\API\PatchEntity;
use App\Http\Requests\API\StoreEntities;
use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\Api\BulkEntityCreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityApiController extends ApiController
{
    public function __construct(
        protected BulkEntityCreatorService $bulkEntityCreatorService,
    ) {}

    public function index(Campaign $campaign)
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
        $this->authorize('access', $campaign);

        return Resource::collection($campaign->entities()
            ->apiFilter(request()->all())
            ->lastSync(request()->get('lastSync'))
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

        foreach ($request->get('entities', []) as $entity) {
            $entities[] = $this->bulkEntityCreatorService->data($entity)->create();
        }

        return Resource::collection($entities);
    }

    public function edit(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        if (! $entity->entityType->isSpecial()) {
            return response()->json(['error' => 'Only entities of custom modules can be deleted here'], 401);
        }

        $entity->update($request->all());

        return new Resource($entity);
    }

    public function patch(PatchEntity $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $keys = ['name', 'type', 'is_private', 'is_template', 'tooltip', 'entry', 'image_uuid', 'header_uuid'];
        if (!$entity->hasChild()) {
            $keys[] = 'parent_id';
        }
    
        $data = $request->only($keys);

        $entity->update($data);
        $entity->crudSaved();

        return new Resource($entity);
    }

    public function destroy(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $entity);

        if (! $entity->entityType->isSpecial()) {
            return response()->json(['error' => 'Only entities of custom modules can be deleted here'], 401);
        }

        $entity->delete();

        return response()->json(['success'], 204);
    }
}
