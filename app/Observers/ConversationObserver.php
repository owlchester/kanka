<?php

namespace App\Observers;

use App\Models\MiscModel;

class ConversationObserver extends MiscObserver
{
    /**
     */
    public function updated(MiscModel $model)
    {
        // Changed the target? Remove participants.
        if ($model->isDirty('target')) {
            $model->participants()->delete();
        }
    }
}
