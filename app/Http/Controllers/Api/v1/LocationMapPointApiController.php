<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Location;
use App\Http\Requests\StoreMapPoint as Request;
use App\Http\Resources\MapPointResource as Resource;
use App\Models\MapPoint;

class LocationMapPointApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $location);
        return Resource::collection($location->mapPoints);
    }

    /**
     * @param Campaign $campaign
     * @param Location $location
     * @param MapPoint $mapPoint
     * @return Resource
     */
    public function show(Campaign $campaign, Location $location, MapPoint $mapPoint)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $location);
        return new Resource($mapPoint);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Location $location)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $location);
        $model = MapPoint::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Location $location
     * @param MapPoint $mapPoint
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Location $location, MapPoint $mapPoint)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $location);
        $mapPoint->update($request->all());

        return new Resource($mapPoint);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Location $location
     * @param MapPoint $mapPoint
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Location $location,
        MapPoint $mapPoint
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $location);
        $mapPoint->delete();

        return response()->json(null, 204);
    }
}
