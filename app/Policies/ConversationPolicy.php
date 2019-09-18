<?php

namespace App\Policies;

use App\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy extends MiscPolicy
{
    protected $model = 'conversation';
}
