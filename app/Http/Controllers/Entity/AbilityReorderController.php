<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderAbility;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\AbilityService;

class AbilityReorderController extends Controller
{
    protected AbilityService $service;

    public function __construct(AbilityService $abilityService)
    {
        $this->service = $abilityService;
    }
    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $abilities = $entity->abilities()
            ->select('entity_abilities.*')
            ->with(['ability',
                // entity
                'ability.entity', 'ability.entity.image', 'ability.entity.attributes',
                // parent
                'ability.ability', 'ability.ability.entity'
            ])
            ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
            ->defaultOrder()
            ->get();

        $parents = [];
        foreach ($abilities as $ability) {
            // Missing permission to view the ability
            if (empty($ability->ability)) {
                continue;
            }
            if (array_key_exists($ability->ability->ability_id, $parents)) {
                $parents[$ability->ability->ability_id][] = $ability;
            } else {
                $parents[$ability->ability->ability_id] = [$ability];
            }
        }

        return view('entities.pages.abilities.reorder.index', compact(
            'campaign',
            'entity',
            'parents'
        ));
    }

    /**
     * @param Entity $entity
     * @param ReorderAbility $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Campaign $campaign, Entity $entity, ReorderAbility $request)
    {
        $this->authorize('update', $entity->child);
        $this->service
            ->entity($entity)
            ->reorder($request);
        return redirect()
            ->route('entities.entity_abilities.index', [$campaign, $entity])
            ->withSuccess(__('entities/abilities.reorder.success'));
    }
}
