<?php

namespace App\Policies;

use App\Models\ConversationMessage;
use App\User;
use Carbon\Carbon;

class ConversationMessagePolicy
{
    /**
     * Allow deleting a message for up to one hour by the author
     * @param User|null $user
     * @param ConversationMessage $message
     * @return bool
     */
    public function delete(?User $user, ConversationMessage $message): bool
    {
        $elapsedHours = $message->created_at->diffInHours(Carbon::now());
        return $message->created_by === $user->id && ($elapsedHours < 1);
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
