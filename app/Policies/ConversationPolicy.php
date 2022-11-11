<?php

namespace App\Policies;

use App\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.conversation');
    }
}
