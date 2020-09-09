<?php


namespace App\Policies;


use App\Models\CommunityEventEntry;
use App\User;

class CommunityEventEntryPolicy
{
    /**
     * Determine whether the user can delete the entry.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignPermission  $campaignPermission
     * @return bool
     */
    public function delete(User $user, CommunityEventEntry $communityEventEntry): bool
    {
        return $user->id == $communityEventEntry->created_by && $communityEventEntry->event->isOngoing();
    }
}
