<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Ability;
use App\Http\Requests\StoreAbility as Request;
use App\Http\Resources\AbilityResource as Resource;

class AbilityApiController extends ApiController
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
            ->abilities()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files',
                'entity.events', 'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Ability $ability
     * @return Resource
     */
    public function show(Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $ability);
        return new Resource($ability);
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
        $this->authorize('create', Ability::class);
        $model = Ability::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Ability $ability
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $ability);
        $ability->update($request->all());
        $this->crudSave($ability);

        return new Resource($ability);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Ability $ability
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $ability);
        $ability->delete();

        return response()->json(null, 204);
    }
}
