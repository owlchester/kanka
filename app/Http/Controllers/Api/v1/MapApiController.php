<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Map;
use App\Http\Requests\StoreMap as Request;
use App\Http\Resources\MapResource as Resource;

class MapApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->maps()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);
        return new Resource($map);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Map::class);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Map::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $map->entity);
        $map->update($request->all());
        $this->crudSave($map);

        return new Resource($map);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $map->entity);
        $map->delete();

        return response()->json(null, 204);
    }
}
