<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityResource;
use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\EntityService;
use Illuminate\Support\Facades\DB;

class EntityTemplateApiController extends ApiController
{
    /** @var EntityService */
    protected $service;

    /**
     * EntityApiController constructor.
     * @param EntityService $service
     */
    public function __construct(EntityService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Campaign $campaign
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
            ->where('is_template', true)
            ->paginate()
            ->appends(request()->except(['page', 'lastSync'])));
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function switch(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);

        $entity = $this->service->toggleTemplate($entity);

        $resource = new Resource($entity);
        return $resource->withMisc();


    }
}
