<?php

namespace App\Policies;

class ConversationPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.conversation');
    }
}
