<?php

namespace App\Observers;

use App\Models\Event;

class EventObserver extends MiscObserver
{
    public function deleting(Event $event)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($event->events as $sub) {
            $sub->event_id = null;
            $sub->saveQuietly();
        }
    }
}
