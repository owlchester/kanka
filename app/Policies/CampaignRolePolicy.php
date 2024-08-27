<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\User;
use App\Models\CampaignRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use HandlesAuthorization;

    public function view(User $user, CampaignRole $campaignRole, Campaign $campaign): bool
    {
        return $campaignRole->campaign_id === $campaign->id && UserCache::user($user)->admin();
    }

    public function create(User $user)
    {
        return UserCache::user($user)->admin();
    }

    public function update(User $user, CampaignRole $campaignRole)
    {
        return UserCache::user($user)->admin();
    }

    public function delete(User $user, CampaignRole $campaignRole)
    {
        return !$campaignRole->isAdmin() && !$campaignRole->isPublic()
            && UserCache::user($user)->admin();
    }

    public function user(User $user, CampaignRole $campaignRole)
    {
        return UserCache::user($user)->admin();
    }

    /**
     * Only allow removing users from the admin role is there is more than one user in it
     */
    public function removeUser(User $user, CampaignRole $campaignRole)
    {
        if (!$this->user($user, $campaignRole)) {
            return false;
        }

        // Non-admin role? Yep the user can modify the member
        return (bool) (!$campaignRole->isAdmin());
    }

    public function permission(User $user, CampaignRole $campaignRole)
    {
        return !$campaignRole->isAdmin()
            && UserCache::user($user)->admin();
    }
}
