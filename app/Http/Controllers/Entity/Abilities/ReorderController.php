<?php

namespace App\Http\Controllers\Entity\Abilities;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderAbility;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Abilities\ReorderService;
use Illuminate\Database\Query\JoinClause;

class ReorderController extends Controller
{
    public function __construct(protected ReorderService $reorderService)
    {
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
                'ability.entity.parent', 'ability.entity.parent',
            ])
            ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
            ->leftJoin('entities as ae', function (JoinClause $join) {
                $join
                    ->on('ae.entity_id', '=', 'a.id')
                    ->where('ae.type_id', '=', config('entities.ids.ability'));
            })
            ->defaultOrder()
            ->get();

        $parents = [];
        foreach ($abilities as $ability) {
            // Missing permission to view the ability
            if (empty($ability->ability)) {
                continue;
            }
            if (array_key_exists($ability->ability->entity->parent_id, $parents)) {
                $parents[$ability->ability->entity->parent_id][] = $ability;
            } else {
                $parents[$ability->ability->entity->parent_id] = [$ability];
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
