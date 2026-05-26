<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use HandlesAuthorization;

    public function view(User $user, CampaignRole $campaignRole, Campaign $campaign): bool
    {
        return $campaignRole->campaign_id === $campaign->id && $user->can('admin', $campaign);
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $user->can('admin', $campaign);
    }

    public function update(User $user, CampaignRole $campaignRole): bool
    {
        return $user->can('admin', $campaignRole->campaign);
    }

    public function delete(User $user, CampaignRole $campaignRole): bool
    {
        return ! $campaignRole->isAdmin() && ! $campaignRole->isPublic()
            && $user->can('admin', $campaignRole->campaign);
    }

    public function user(User $user, CampaignRole $campaignRole): bool
    {
        return $user->can('admin', $campaignRole->campaign);
    }

    /**
     * Only allow removing users from the admin role is there is more than one user in it
     */
    public function removeUser(User $user, CampaignRole $campaignRole): bool
    {
        if (! $this->user($user, $campaignRole)) {
            return false;
        }

        // Non-admin role? Yep the user can modify the member
        return (bool) (! $campaignRole->isAdmin());
    }

    public function permission(User $user, CampaignRole $campaignRole): bool
    {
        return ! $campaignRole->isAdmin()
            && $user->can('admin', $campaignRole->campaign);
    }
}
