<?php

namespace App\Observers;

use App\Models\EntityAbility;

class EntityAbilityObserver
{
    use PurifiableTrait;

    public function saving(EntityAbility $entityAbility)
    {
        $entityAbility->note = $this->purify($entityAbility->note);
        if ($entityAbility->position !== null) {
            $entityAbility->position = (int) $entityAbility->position;
        }
    }

    /**
     * @param EntityAbility $entityAbility
     */
    public function saved(EntityAbility $entityAbility)
    {
        if (!$entityAbility->savedObserver) {
            return;
        }

        // Position isn't empty, move the rest
        if ($entityAbility->position !== null) {
            /** @var EntityAbility[] $abilities */
            $position = $entityAbility->position;
            $abilities = EntityAbility::select('entity_abilities.*')
                ->with(['ability'])
                ->has('ability')
                ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
                ->where('entity_id', $entityAbility->entity_id)
                ->where('entity_abilities.id', '<>', $entityAbility->id)
                ->where('position', '>=', $position)
                ->defaultOrder()
                ->get();
            foreach ($abilities as $next) {
                // Check the ability's parent to only move stuff in the same "group"
                if ($next->ability->ability_id != $entityAbility->ability->ability_id) {
                    continue;
                }
                $position++;
                $next->savedObserver = false;
                $next->position = $position;
                $next->save();
            }
        }

        // When adding or changing an entity note to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityAbility->entity->child->savingObserver = false;
        $entityAbility->entity->child->touch();
    }

    /**
     * @param EntityAbility $entityAbility
     */
    public function deleted(EntityAbility $entityAbility)
    {
        // When deleting an entity note, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($entityAbility->entity) {
            $entityAbility->entity->child->touch();
        }
    }
}
