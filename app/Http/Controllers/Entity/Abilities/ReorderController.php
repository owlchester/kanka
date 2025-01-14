<?php

namespace App\Http\Controllers\Entity\Abilities;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderAbility;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Abilities\AbilityService;
use App\Services\Abilities\ReorderService;

class ReorderController extends Controller
{
    protected AbilityService $service;
    protected ReorderService $reorderService;

    public function __construct(AbilityService $abilityService, ReorderService $reorderService)
    {
        $this->service = $abilityService;
        $this->reorderService = $reorderService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        $abilities = $entity->abilities()
            ->select('entity_abilities.*')
            ->with(['ability',
                // entity
                'ability.entity', 'ability.entity.image', 'ability.entity.attributes',
                // parent
                'ability.parent', 'ability.parent.entity'
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

    public function save(Campaign $campaign, Entity $entity, ReorderAbility $request)
    {
        $this->authorize('update', $entity);

        $this->reorderService
            ->entity($entity)
            ->reorder($request);

        return redirect()
            ->route('entities.entity_abilities.index', [$campaign, $entity])
            ->withSuccess(__('entities/abilities.reorder.success'));
    }
}
