<?php

namespace App\Observers;

use App\Models\MiscModel;

class EventObserver extends MiscObserver
{
    public function deleting(MiscModel $event)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($event->events as $sub) {
            $sub->event_id = null;
            $sub->save();
        }

        $this->cleanupTree($event, 'event_id');
    }
}
