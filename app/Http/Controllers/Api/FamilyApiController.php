<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Models\Family;
use App\Http\Requests\StoreFamily as Request;
use App\Http\Resources\Family as Resource;
use App\Http\Resources\FamilyCollection as Collection;

class FamilyApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return new Collection($campaign->families);
    }

    /**
     * @param Campaign $campaign
     * @param Family $family
     * @return Resource
     */
    public function show(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $family);
        return new Resource($family);
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
        $this->authorize('create', Family::class);
        $model = Family::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Family $family
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $family);
        $family->update($request->all());

        return new Resource($family);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Family $family
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $family);
        $family->delete();

        return response()->json(null, 204);
    }
}
