<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Models\Location;
use App\Http\Requests\StoreLocation as Request;
use App\Http\Resources\Location as Resource;
use App\Http\Resources\LocationCollection as Collection;

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
        return new Collection($campaign->locations);
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

        return new Resource($location);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $location);
        $location->delete();

        return response()->json(null, 204);
    }
}
