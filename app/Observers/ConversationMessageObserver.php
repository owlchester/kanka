<?php

namespace App\Observers;

use App\Models\ConversationMessage;

class ConversationMessageObserver
{
    public function created(ConversationMessage $model)
    {
        $model->conversation->touch();
    }
}
