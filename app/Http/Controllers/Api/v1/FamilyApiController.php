<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Family;
use App\Http\Requests\StoreFamily as Request;
use App\Http\Resources\FamilyResource as Resource;

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
        return Resource::collection($campaign
            ->families()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files',
                'entity.events', 'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
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
        $this->crudSave($model);
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
        $this->crudSave($family);

        return new Resource($family);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Family $family
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $family);
        $family->delete();

        return response()->json(null, 204);
    }
}
