<?php

namespace App\Policies;

use App\Models\ConversationMessage;
use App\User;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationMessagePolicy
{
    /**
     * @param User|null $user
     * @param ConversationMessage $message
     * @return bool
     */
    public function delete(?User $user, ConversationMessage $message): bool
    {
        $elapsed = $message->created_at->diffInHours(Carbon::now());
        return $message->created_by == $user->id && ($elapsed < 1);
    }

    /**
     * @param User|null $user
     * @param ConversationMessage $message
     * @return bool
     */
    public function edit(?User $user, ConversationMessage $message): bool
    {
        return $this->delete($user, $message);
    }
}
