<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMapGroup as Request;
use App\Http\Resources\MapGroupResource as Resource;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;

class MapGroupApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);

        return Resource::collection($map->groups()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);

        return new Resource($mapGroup);
    }

    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        if ($map->groups->count() >= $campaign->maxMapLayers()) {
            return response()->json(['error' => 'Max amount of map groups reached']);
        }

        $model = MapGroup::create($request->all());

        return new Resource($model);
    }

    public function update(
        Request $request,
        Campaign $campaign,
        Map $map,
        MapGroup $mapGroup
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $mapGroup->update($request->all());

        return new Resource($mapGroup);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Map $map,
        MapGroup $mapGroup
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $mapGroup->delete();

        return response()->json(null, 204);
    }
}
