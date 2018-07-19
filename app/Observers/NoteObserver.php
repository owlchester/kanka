<?php

namespace App\Observers;

use App\Models\MiscModel;

class NoteObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Is Pinned hook for non-admin (who can't set is_pinned)
        if (!isset($model->is_pinned)) {
            $model->is_pinned = false;
        }
    }
}
