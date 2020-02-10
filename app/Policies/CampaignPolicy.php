<?php

namespace App\Policies;

use App\Facades\Identity;
use App\Traits\AdminPolicyTrait;
use App\Traits\EnvTrait;
use App\User;
use App\Models\Campaign;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization, AdminPolicyTrait, EnvTrait;

    /**
     * Determine whether the user can view the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return mixed
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id;
    }

    /**
     * Determine whether the user can access the campaign
     *
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function access(User $user, Campaign $campaign): bool
    {
        if ($campaign->visibility == 'public') {
            return true;
        }
        return $campaign->userIsMember();
    }

    /**
     * Determine whether the user can create campaigns.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return !Identity::isImpersonating() && !$this->shadow();
    }

    /**
     * Determine whether the user can update the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return mixed
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return
            $user->campaign->id == $campaign->id && $this->isAdmin($user) && !$this->shadow();
    }

    /**
     * Determine whether the user can delete the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return mixed
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return
            !$this->shadow() &&
            $user->campaign->id == $campaign->id && $this->isAdmin($user) && $campaign->members()->count() == 1;
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function invite(User $user, Campaign $campaign): bool
    {
        return !$this->shadow() && $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function setting(User $user, Campaign $campaign): bool
    {
        return !$this->shadow() && $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function dashboard(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function search(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can leave the campaign
     *
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function leave(User $user, Campaign $campaign)
    {
        return !$this->shadow() &&
            $user->campaign->id == $campaign->id &&
            // If we are not the owner, or that we are an owner but there are other owners
            $campaign->userIsMember() && (!$this->isAdmin($user) || count($campaign->admins()) > 1) &&
            // We also can't leave a campaign if we are not the real user
            !Identity::isImpersonating();
    }

    /**
     * Determine if a user can follow a campaign
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function follow(User $user, Campaign $campaign)
    {
        if ($this->shadow()) {
            return false;
        }

        if (empty($user)) {
            return false;
        }

        if ($campaign->visibility != Campaign::VISIBILITY_PUBLIC) {
            return false;
        }

        return !$campaign->userIsMember();
    }
}
