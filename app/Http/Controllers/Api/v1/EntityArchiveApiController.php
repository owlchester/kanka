<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\ArchiveService;
use Illuminate\Support\Facades\DB;

class EntityArchiveApiController extends ApiController
{
    protected ArchiveService $service;

    public function __construct(ArchiveService $archiveService)
    {
        $this->service = $archiveService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
        $this->authorize('access', $campaign);

        return Resource::collection($campaign->entities()
            ->apiFilter($campaign, request()->all())
            ->lastSync(request()->get('lastSync'))
            ->whereNotNull('archived_at')
            ->paginate()
            ->appends(request()->except(['page', 'lastSync'])));
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function switch(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        $this->service->entity($entity)->toggle();

        $resource = new Resource($entity);

        return $resource->withMisc();
    }
}
