<?php

namespace App\Policies;

use App\Models\CommunityEventEntry;
use App\Models\User;

class CommunityEventEntryPolicy
{
    /**
     * Determine whether the user can delete the entry.
     */
    public function delete(User $user, CommunityEventEntry $communityEventEntry): bool
    {
        return ($user->id == $communityEventEntry->created_by) && $communityEventEntry->event->isOngoing();
    }
}
