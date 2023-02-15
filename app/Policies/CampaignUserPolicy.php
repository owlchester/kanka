<?php

namespace App\Policies;

use App\Facades\Identity;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignUserPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaignUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return mixed
     */
    public function view(User $user, CampaignUser $campaignUser)
    {
    }

    /**
     * Determine whether the user can create campaignUsers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the campaignUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return mixed
     */
    public function update(User $user, CampaignUser $campaignUser)
    {
        // Don't allow updating if we are currently impersonating
        if (Identity::isImpersonating()) {
            return false;
        }
        if ($user->campaign->id !== $campaignUser->campaign->id) {
            return false;
        }

        if (!UserCache::user($user)->admin()) {
            return false;
        }

        if ($user->id === $campaignUser->user_id) {
            return false;
        }

        if (!$campaignUser->user->isAdmin()) {
            return true;
        }

        // Check if the user was added to the admin role recently
        /** @var CampaignRoleUser $adminRole */
        $adminRole = UserCache::adminRole()->first();
        $role = $campaignUser->user->campaignRoleUser->where('campaign_role_id', $adminRole->id)->first();
        return $role->created_at->diffInMinutes() <= 15;
    }

    /**
     * Determine whether the user can delete the campaignUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return mixed
     */
    public function delete(User $user, CampaignUser $campaignUser)
    {
        return $this->update($user, $campaignUser);
    }

    /**
     * Determine whether the current user can switch to the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return mixed
     */
    public function switch(User $user, CampaignUser $campaignUser, Campaign $campaign)
    {
        if (Identity::isImpersonating()) {
            return false;
        }
        return $campaign->id == $campaignUser->campaign->id
            && $user->isAdmin() && !$campaignUser->user->isAdmin()
            && !$campaignUser->user->isBanned()
        ;
    }
}
