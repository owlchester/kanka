<?php


namespace App\Observers;


use App\Models\EntityEvent;

class EntityEventObserver
{
    /**
     * @param EntityEvent $entityEvent
     */
    public function saving(EntityEvent $entityEvent)
    {
        $entityEvent->is_recurring = !empty($entityEvent->recurring_periodicity);
        if (!$entityEvent->is_recurring) {
            $entityEvent->recurring_until = null;
        }
    }
}
