<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCreature as Request;
use App\Http\Resources\CreatureResource as Resource;
use App\Models\Campaign;
use App\Models\Creature;
use App\Models\EntityType;

class CreatureApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->creatures()
            ->filter(request()->all())
            ->withApi()
            ->has('entity')
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Creature $creature)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $creature->entity);

        return new Resource($creature);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.creature')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Creature::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Creature $creature)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $creature->entity);
        $creature->update($request->all());
        $this->crudSave($creature);

        return new Resource($creature);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Creature $creature)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $creature->entity);
        $creature->delete();

        return response()->json(null, 204);
    }
}
