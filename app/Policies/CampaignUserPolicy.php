<?php

namespace App\Policies;

use App\User;
use App\CampaignUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaignUser.
     *
     * @param  \App\User  $user
     * @param  \App\CampaignUser  $campaignUser
     * @return mixed
     */
    public function view(User $user, CampaignUser $campaignUser)
    {
        //
    }

    /**
     * Determine whether the user can create campaignUsers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the campaignUser.
     *
     * @param  \App\User  $user
     * @param  \App\CampaignUser  $campaignUser
     * @return mixed
     */
    public function update(User $user, CampaignUser $campaignUser)
    {
        return $user->campaign->id == $campaignUser->campaign->id && $user->owner() && $campaignUser->role != 'owner';
    }

    /**
     * Determine whether the user can delete the campaignUser.
     *
     * @param  \App\User  $user
     * @param  \App\CampaignUser  $campaignUser
     * @return mixed
     */
    public function delete(User $user, CampaignUser $campaignUser)
    {
        return $user->campaign->id == $campaignUser->campaign->id && $user->owner() && $campaignUser->role != 'owner';
    }
}
