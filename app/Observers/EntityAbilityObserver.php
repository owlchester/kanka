<?php

namespace App\Observers;

use App\Models\EntityAbility;
use Illuminate\Database\Query\JoinClause;

class EntityAbilityObserver
{
    public function saving(EntityAbility $entityAbility)
    {
        if ($entityAbility->position !== null) {
            $entityAbility->position = (int) $entityAbility->position;
        }
    }

    public function saved(EntityAbility $entityAbility)
    {
        // Position isn't empty, move the rest
        if ($entityAbility->position !== null) {
            $position = $entityAbility->position;
            $abilities = EntityAbility::select('entity_abilities.*')
                ->with(['ability', 'ability.entity'])
                ->has('ability')
                ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
                ->leftJoin('entities as ae', function (JoinClause $join) {
                    $join
                        ->on('ae.entity_id', '=', 'a.id')
                        ->where('ae.type_id', '=', config('entities.ids.ability'));
                })
                ->where(function ($query) use ($entityAbility) {
                    $query->where('ae.id', $entityAbility->entity_id)
                        ->orWhereNull('ae.id');
                })
                ->where('entity_abilities.entity_id', $entityAbility->entity_id)
                ->where('entity_abilities.id', '<>', $entityAbility->id)
                ->where('position', '>=', $position)
                ->defaultOrder()
                ->get();
            /** @var EntityAbility $next */
            foreach ($abilities as $next) {
                // No access, skip
                if (! $next->ability || ! $entityAbility->ability) {
                    continue;
                }
                // Check the ability's parent to only move stuff in the same "group"
                if ($next->ability->ability_id != $entityAbility->ability->ability_id) {
                    continue;
                }
                $position++;
                $next->position = $position;
                $next->saveQuietly();
            }
        }

        // When adding or changing an entity ability to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        if ($entityAbility->entity) {
            $entityAbility->entity->touchQuietly();
        }
    }

    public function deleted(EntityAbility $entityAbility)
    {
        // When deleting an entity ability, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($entityAbility->entity) {
            $entityAbility->entity->touchQuietly();
        }
    }
}
