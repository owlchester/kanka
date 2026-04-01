<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMapMarker as Request;
use App\Http\Resources\MapMarkerResource as Resource;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MapMarkerApiController extends ApiController
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

        return Resource::collection($map->markers()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);

        return new Resource($mapMarker);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $data = $request->all();
        $data['map_id'] = $map->id;
        $model = MapMarker::create($data);

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
        MapMarker $mapMarker
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $mapMarker->update($request->all());

        return new Resource($mapMarker);
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
        MapMarker $mapMarker
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $mapMarker->delete();

        return response()->json(null, 204);
    }
}
