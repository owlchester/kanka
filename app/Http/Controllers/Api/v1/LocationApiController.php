<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Location;
use App\Http\Requests\StoreLocation as Request;
use App\Http\Resources\LocationResource as Resource;

class LocationApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->locations()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $location);

        return new Resource($location);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Location::class);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Location::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $location);
        $location->delete();

        return response()->json(null, 204);
    }
}
