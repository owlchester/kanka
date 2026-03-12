<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreEntityAbility as Request;
use App\Http\Resources\EntityAbilityResource as Resource;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityAbility;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class EntityAbilityApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->abilities()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($entityAbility);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        if (isset($data['abilities']) && is_array($data['abilities'])) {
            $models = new Collection;
            foreach ($data['abilities'] as $abilityId) {
                $ability = Ability::find($abilityId);
                if (! $ability) {
                    continue;
                }
                $data['ability_id'] = $ability->id;
                $models->add(EntityAbility::create($data));
            }

            return Resource::collection($models);
        }

        $model = EntityAbility::create($data);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityAbility->update($request->all());

        return new Resource($entityAbility);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        EntityAbility $entityAbility
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityAbility->delete();

        return response()->json(null, 204);
    }
}
