<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TemplateService;
use Illuminate\Support\Facades\DB;

class EntityTemplateApiController extends ApiController
{
    protected TemplateService $service;

    public function __construct(TemplateService $templateService)
    {
        $this->service = $templateService;
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
            ->apiFilter(request()->all())
            ->lastSync(request()->get('lastSync'))
            ->where('is_template', true)
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
