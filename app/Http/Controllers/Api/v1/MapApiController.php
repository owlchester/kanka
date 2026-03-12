<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreMap as Request;
use App\Http\Resources\MapResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Map;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MapApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @return resource
     */
    public function show(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $map->entity);

        return new Resource($map);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.map')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Map::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
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
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Map $map)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $map->entity);
        $map->delete();

        return response()->json(null, 204);
    }
}
