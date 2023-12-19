<?php

namespace App\Observers;

use App\Models\EntityEvent;

class EntityEventObserver
{
    /**
     */
    public function saving(EntityEvent $entityEvent)
    {
        $entityEvent->is_recurring = !empty($entityEvent->recurring_periodicity);
        if (!$entityEvent->is_recurring) {
            $entityEvent->recurring_until = null;
        }
    }

    public function updating(EntityEvent $entityEvent)
    {
        // When updating and elapsed isn't dirty (calculated on the overview), reset it
        if ($entityEvent->isDirty(['year', 'month', 'day', 'calendar_id'])) {
            $entityEvent->elapsed = null;
        }
    }
}
