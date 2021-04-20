<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Resources\EntityResource as Resource;
use Illuminate\Support\Facades\DB;

class EntityApiController extends ApiController
{
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
     * @param Campaign $campaign
     * @param Entity $entity
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity)
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        $resource = new Resource($entity);
        return $resource->withMisc();
    }
}
