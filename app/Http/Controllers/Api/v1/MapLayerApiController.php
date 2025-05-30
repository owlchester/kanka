<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMapLayer as Request;
use App\Http\Resources\MapLayerResource as Resource;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;

class MapLayerApiController extends ApiController
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

        return Resource::collection($map->layers()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);

        return new Resource($mapLayer);
    }

    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);

        if (! auth()->user()->can('addLayer', [$map, $campaign])) {
            return response()->json(['error' => 'Max amount of map layers reached']);
        }

        $model = MapLayer::create($request->all());
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Map $map,
        MapLayer $mapLayer
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $mapLayer->update($request->all());

        return new Resource($mapLayer);
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
        MapLayer $mapLayer
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $mapLayer->delete();

        return response()->json(null, 204);
    }
}
