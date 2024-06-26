<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Ability;
use App\Http\Requests\StoreAbility as Request;
use App\Http\Resources\AbilityResource as Resource;

class AbilityApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->abilities()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $ability);
        return new Resource($ability);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Ability::class);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Ability::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $ability);
        $ability->delete();

        return response()->json(null, 204);
    }
}
