<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMapLayer as Request;
use App\Http\Resources\MapLayerResource as Resource;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MapLayerApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
        $this->ensureLayerBelongsToMap($map, $mapLayer);

        return new Resource($mapLayer);
    }

    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);

        if (! auth()->user()->can('addLayer', [$map, $campaign])) {
            return response()->json(['error' => 'Max amount of map layers reached']);
        }

        $model = $map->layers()->create($request->validated());
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Map $map,
        MapLayer $mapLayer
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $this->ensureLayerBelongsToMap($map, $mapLayer);
        $mapLayer->update($request->validated());

        return new Resource($mapLayer);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Map $map,
        MapLayer $mapLayer
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $this->ensureLayerBelongsToMap($map, $mapLayer);
        $mapLayer->delete();

        return response()->json(null, 204);
    }

    private function ensureLayerBelongsToMap(Map $map, MapLayer $mapLayer): void
    {
        abort_unless((int) $mapLayer->map_id === (int) $map->id, 404);
    }
}
