<?php

namespace App\Observers;

use App\Models\EntityAbility;

class EntityAbilityObserver
{
    /**
     * @param EntityAbility $entityAbility
     */
    public function saved(EntityAbility $entityAbility)
    {
        if (!$entityAbility->savedObserver) {
            return;
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
