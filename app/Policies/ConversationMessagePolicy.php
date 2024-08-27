<?php

namespace App\Policies;

use App\Models\ConversationMessage;
use App\Models\User;
use Carbon\Carbon;

class ConversationMessagePolicy
{
    /**
     * Allow deleting a message for up to one hour by the author
     */
    public function delete(?User $user, ConversationMessage $message): bool
    {
        $elapsedHours = $message->created_at->diffInHours(Carbon::now());
        return $message->created_by === $user->id && ($elapsedHours < 1);
    }

    /**
     */
    public function edit(?User $user, ConversationMessage $message): bool
    {
        return $this->delete($user, $message);
    }
}
