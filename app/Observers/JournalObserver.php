<?php

namespace App\Observers;

use App\Models\Journal;
use App\Models\MiscModel;

class JournalObserver extends MiscObserver
{
    /**
     * @param Journal $journal
     */
    public function deleting(MiscModel $journal)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         */
        foreach ($journal->journals as $sub) {
            $sub->journal_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $journal->refresh();
    }
}
