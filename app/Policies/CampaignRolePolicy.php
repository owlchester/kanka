<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\User;
use App\Models\CampaignRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function create(User $user)
    {
        return UserCache::user($user)->admin();
    }

    public function update(User $user, CampaignRole $campaignRole)
    {
        return $user->campaign->id == $campaignRole->campaign->id && UserCache::user($user)->admin();
    }

    public function delete(User $user, CampaignRole $campaignRole)
    {
        return !$campaignRole->is_admin && !$campaignRole->is_public
            && $user->campaign->id == $campaignRole->campaign->id && UserCache::user($user)->admin();
    }

    public function user(User $user, CampaignRole $campaignRole)
    {
        return $user->campaign->id == $campaignRole->campaign->id && UserCache::user($user)->admin();
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
        return !$campaignRole->isAdmin() && $user->campaign->id == $campaignRole->campaign->id
            && UserCache::user($user)->admin();
    }
}
