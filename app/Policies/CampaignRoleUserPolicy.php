<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignRoleUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRoleUserPolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    /**
     * Determine whether the user can view the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function view(User $user, CampaignRoleUser $campaignRoleUser)
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create campaignRoleUsers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Campaign $campaign)
    {
        return $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function update(User $user, CampaignRoleUser $campaignRoleUser)
    {
        return $user->campaign->id == $campaignRoleUser->campaign->id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function delete(User $user, CampaignRoleUser $campaignRoleUser, CampaignRole $campaignRole)
    {
        // Don't delete yourself
        if ($user->id === $campaignRoleUser->user_id) {
            return false;
        }
        // If not an admin, don't allow removing
        if (!$user->isAdmin()) {
            return false;
        }

        // User is an admin, only allow deleting if the role is the admin role and the user
        // was added less than 15 minutes ago (aka by accident)
        return !$campaignRole->isAdmin() || $campaignRoleUser->created_at->diffInMinutes() <= 15;
    }
}
