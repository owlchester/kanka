<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Location;
use App\Http\Requests\StoreLocation as Request;
use App\Http\Resources\LocationResource as Resource;

class LocationApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->locations()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files',
                'entity.events', 'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Location $location
     * @return Resource
     */
    public function show(Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $location);

        return new Resource($location);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Location::class);
        $model = Location::create($request->all());
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Location $location
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $location);
        $location->update($request->all());
        $this->crudSave($location);

        return new Resource($location);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $location);
        $location->delete();

        return response()->json(null, 204);
    }
}
