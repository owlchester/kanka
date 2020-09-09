<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Note;

class NoteObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

    }
    /**
     * @param Note $note
     */
    public function deleting(MiscModel $note)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         */
        foreach ($note->notes as $sub) {
            $sub->note_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $note->refresh();
    }
}
