<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignInvite;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignInvitePolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    /**
     * Determine whether the user can view the campaignInvite.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignInvite  $campaignInvite
     * @return mixed
     */
    public function view(User $user, CampaignInvite $campaignInvite)
    {
        //
    }

    /**
     * Determine whether the user can create campaignInvites.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Campaign $campaign)
    {
        return $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the campaignInvite.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignInvite  $campaignInvite
     * @return mixed
     */
    public function update(User $user, CampaignInvite $campaignInvite)
    {
        return $user->campaign->id == $campaignInvite->campaign->id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the campaignInvite.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignInvite  $campaignInvite
     * @return mixed
     */
    public function delete(User $user, CampaignInvite $campaignInvite)
    {
        return $user->campaign->id == $campaignInvite->campaign->id && $this->isAdmin($user);
    }
}
