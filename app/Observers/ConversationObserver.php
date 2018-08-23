<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\MiscModel;

class ConversationObserver extends MiscObserver
{
    public function updating(Conversation $model)
    {
        // Changed the target? Remove participants.
        if ($model->isDirty('target')) {
            $model->participants()->delete();
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);
    }

    /**
     * @param MiscModel $model
     */
    public function creating(MiscModel $model)
    {
        $model->created_by = auth()->user()->id;
    }
}
