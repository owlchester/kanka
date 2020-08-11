<?php


namespace App\Observers;


use App\Models\EntityEvent;

class EntityEventObserver
{
    public function saving(EntityEvent $entityEvent)
    {
        if (!empty($entityEvent->type_id)) {
            // Compare to the calendar
            $calendar = $entityEvent->calendar;

            $years = $calendar->currentDate('year') - $entityEvent;
        }
    }
}
