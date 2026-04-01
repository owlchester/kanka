<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreAbility as Request;
use App\Http\Resources\AbilityResource as Resource;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\EntityType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AbilityApiController extends MiscApiController
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
            ->abilities()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $ability->entity);

        return new Resource($ability);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.ability')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Ability::create($data);
        $this->crudSave($model, $request->validated());

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $ability->entity);
        $ability->update($request->all());
        $this->crudSave($ability, $request->validated());

        return new Resource($ability);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Ability $ability)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $ability->entity);
        $ability->delete();

        return response()->json(null, 204);
    }
}
