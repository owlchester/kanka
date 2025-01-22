<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use App\Models\CampaignRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use HandlesAuthorization;

    public function view(User $user, CampaignRole $campaignRole, Campaign $campaign): bool
    {
        return $campaignRole->campaign_id === $campaign->id && $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, CampaignRole $campaignRole)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, CampaignRole $campaignRole)
    {
        return !$campaignRole->isAdmin() && !$campaignRole->isPublic()
            && $user->isAdmin();
    }

    public function user(User $user, CampaignRole $campaignRole)
    {
        return $user->isAdmin();
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
            && $user->isAdmin();
    }
}
