<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Map;
use App\Models\Campaign;
use App\Models\MapLayer;
use App\Http\Requests\StoreMapLayer as Request;
use App\Http\Resources\MapLayerResource as Resource;

class MapLayerApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map);
        return Resource::collection($map->layers()->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map);
        return new Resource($mapLayer);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map);
        $model = MapLayer::create($request->all());
        return new Resource($model);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Map $map,
        MapLayer $mapLayer
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map);
        $mapLayer->update($request->all());

        return new Resource($mapLayer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Map $map,
        MapLayer $mapLayer
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map);
        $mapLayer->delete();

        return response()->json(null, 204);
    }
}
