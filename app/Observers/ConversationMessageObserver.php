<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\MiscModel;

class ConversationMessageObserver
{
    public function created(ConversationMessage $model)
    {
        $model->conversation->touch();
    }
}
