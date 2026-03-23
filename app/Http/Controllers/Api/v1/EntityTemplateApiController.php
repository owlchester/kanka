<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TemplateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class EntityTemplateApiController extends ApiController
{
    protected TemplateService $service;

    public function __construct(TemplateService $templateService)
    {
        $this->service = $templateService;
    }

    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
            ->where('is_template', true)
            ->paginate()
            ->appends(request()->except(['page', 'lastSync'])));
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
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
