<?php

namespace App\Observers;

use App\Models\Conversation;
use App\Models\MiscModel;

class ConversationObserver extends MiscObserver
{
    public function updated(MiscModel $model)
    {
        // Changed the target? Remove participants.
        if ($model->isDirty('target')) {
            /** @var Conversation $model */
            $model->participants()->delete();
        }
    }
}
