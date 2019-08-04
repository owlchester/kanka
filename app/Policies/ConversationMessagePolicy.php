<?php

namespace App\Policies;

use App\Models\ConversationMessage;
use App\User;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationMessagePolicy
{
    public function delete(?User $user, ConversationMessage $message)
    {
        $elapsed = $message->created_at->diffInHours(Carbon::now());
        return $message->created_by == $user->id && ($elapsed < 1);
    }
}
