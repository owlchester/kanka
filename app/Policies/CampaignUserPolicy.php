<?php

namespace App\Policies;

use App\Facades\Identity;
use App\Facades\UserCache;
use App\Traits\AdminPolicyTrait;
use App\Traits\EnvTrait;
use App\User;
use App\Models\CampaignUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignUserPolicy
{
    use HandlesAuthorization, AdminPolicyTrait, EnvTrait;

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
        return $user->campaign->id == $campaignUser->campaign->id &&
            // Don't allow updating if we are currently impersonating
            !Identity::isImpersonating()
            && UserCache::user($user)->admin() && !UserCache::user($campaignUser->user)->admin() &&
            !$this->shadow()
        ;
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
        return $user->campaign->id == $campaignUser->campaign->id &&
            // Don't allow deleting if we are currently impersonating
            !Identity::isImpersonating()
            && UserCache::user($user)->admin() && !UserCache::user($campaignUser->user)->admin() &&
            !$this->shadow()
        ;
    }

    /**
     * Determine whether the current user can switch to the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return mixed
     */
    public function switch(User $user, CampaignUser $campaignUser)
    {
        return $user->campaign->id == $campaignUser->campaign->id &&
            // Don't allow impersonating if we are already impersonating
            !Identity::isImpersonating()
            && UserCache::user($user)->admin() && !UserCache::user($campaignUser->user)->admin() &&
            !$this->shadow()
        ;
    }
}
