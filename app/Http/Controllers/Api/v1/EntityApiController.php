<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Http\Requests\API\StoreEntities;
use App\Http\Resources\EntityResource as Resource;
use App\Models\MiscModel;
use App\Services\Api\BulkEntityCreatorService;
use Illuminate\Support\Facades\DB;

class EntityApiController extends ApiController
{
    protected BulkEntityCreatorService $bulkEntityCreatorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BulkEntityCreatorService $bulkEntityCreatorService)
    {
        $this->bulkEntityCreatorService = $bulkEntityCreatorService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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

    /**
     * @return Resource
     */
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

    public function put(StoreEntities $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);

        $entityTypes = [];
        $models = [];

        $this->bulkEntityCreatorService->campaign($campaign);

        foreach ($request->entities as $entity) {

            if (!array_key_exists($entity['module'], $entityTypes)) {
                $entityTypes[$entity['module']] = EntityType::where('id', $entity['module'])
                    ->whereNotIn('code', ['bookmark', 'dice_roll', 'conversation'])->first();
            }
            if (!isset($entityTypes[$entity['module']])) {
                continue;
            }
            $class = $entityTypes[$entity['module']]->getClass();
            $this->authorize('create', $class);

            $model = $this->bulkEntityCreatorService->class($class)->saveEntity($entity);

            array_push($models, $model->entity);
        }
        return Resource::collection($models);
    }
}
