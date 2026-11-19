<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMapGroup as Request;
use App\Http\Resources\MapGroupResource as Resource;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MapGroupApiController extends ApiController
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

        return Resource::collection($map->groups()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);
        $this->ensureGroupBelongsToMap($map, $mapGroup);

        return new Resource($mapGroup);
    }

    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        if (! auth()->user()->can('addGroup', [$map, $campaign])) {
            return response()->json(['error' => 'Max amount of map groups reached']);
        }

        $model = $map->groups()->create($request->validated());

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
        $this->ensureGroupBelongsToMap($map, $mapGroup);
        $mapGroup->update($request->validated());

        return new Resource($mapGroup);
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
        MapGroup $mapGroup
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $this->ensureGroupBelongsToMap($map, $mapGroup);
        $mapGroup->delete();

        return response()->json(null, 204);
    }

    private function ensureGroupBelongsToMap(Map $map, MapGroup $mapGroup): void
    {
        abort_unless((int) $mapGroup->map_id === (int) $map->id, 404);
    }
}
