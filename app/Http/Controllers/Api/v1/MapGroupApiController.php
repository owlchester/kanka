<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Map;
use App\Models\Campaign;
use App\Models\MapGroup;
use App\Http\Requests\StoreMapGroup as Request;
use App\Http\Resources\MapGroupResource as Resource;

class MapGroupApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map);
        return Resource::collection($map->groups()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param MapGroup $mapGroup
     * @return Resource
     */
    public function show(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map);
        return new Resource($mapGroup);
    }

    /**
     * @param StoreMapGroup $remapGroup
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map);
        $model = MapGroup::create($request->all());
        return new Resource($model);
    }

    /**
     * @param StoreMapGroup $remapGroup
     * @param Campaign $campaign
     * @param MapGroup $mapGroup
     * @return Resource
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Map $map,
        MapGroup $mapGroup
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map);
        $mapGroup->update($request->all());

        return new Resource($mapGroup);
    }

    /**
     * @param Request
     * @param Campaign $campaign
     * @param MapGroup $mapGroup
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Map $map,
        MapGroup $mapGroup
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map);
        $mapGroup->delete();

        return response()->json(null, 204);
    }
}
