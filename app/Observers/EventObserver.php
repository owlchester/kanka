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

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $event->refresh();

        if ($event->descendants()->count() > 0) {
            foreach ($event->descendants as $sub) {
                if (!empty($sub->event_id)) {
                    continue;
                }

                // Got a descendant with the parent id null. Let's get them out of the tree
                $sub->{$sub->getLftName()} = null;
                $sub->{$sub->getRgtName()} = null;
                $sub->save();
            }
        }
    }
}
