<?php

namespace App\Policies;

use App\Facades\CampaignCache;
use App\Facades\EntityPermission;
use App\Facades\Identity;
use App\Facades\UserCache;
use App\Models\CampaignPermission;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\Campaign;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return bool
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
        if ($campaign->isPublic()) {
            return true;
        }
        return $campaign->userIsMember();
    }

    /**
     * Determine whether the user can create campaigns.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return !Identity::isImpersonating();
    }

    /**
     * Determine whether the user can update the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return bool
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return
            $user->campaign->id == $campaign->id && (
                UserCache::user($user)->admin() || $this->checkPermission(CampaignPermission::ACTION_MANAGE, $user)
            );
    }

    /**
     * Determine whether the user can manage the roles of the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return bool
     */
    public function roles(User $user, Campaign $campaign): bool
    {
        return
            $user->campaign->id == $campaign->id && (
                UserCache::user($user)->admin()
            );
    }

    /**
     * Determine whether the user can delete the campaign.
     *
     * @param  User  $user
     * @param  Campaign  $campaign
     * @return bool
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return
            $user->campaign->id == $campaign->id &&
            UserCache::user($user)->admin() &&
            CampaignCache::members()->count() == 1;
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function invite(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && (
            UserCache::user($user)->admin() || $this->checkPermission(CampaignPermission::ACTION_MEMBERS, $user, $campaign)
        );
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function setting(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && UserCache::user($user)->admin();
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function recover(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && UserCache::user($user)->admin();
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function history(User $user, Campaign $campaign): bool
    {
        return $this->recover($user, $campaign);
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function dashboard(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && (
            UserCache::user($user)->admin() || $this->checkPermission(CampaignPermission::ACTION_DASHBOARD, $user, $campaign)
        );
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function stats(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && (UserCache::user($user)->admin() || $campaign->userIsMember());
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function search(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && UserCache::user($user)->admin();
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
        if (Identity::isImpersonating()) {
            return false;
        }
        if (!$campaign->userIsMember()) {
            return false;
        }
        return
            $user->campaign->id == $campaign->id &&
            // If we are not the owner, or that we are an owner but there are other owners
            (!UserCache::user($user)->admin() || $campaign->adminCount() > 1);
    }

    /**
     * Determine if a user can follow a campaign
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function follow(?User $user, Campaign $campaign)
    {
        if (empty($user)) {
            return false;
        }

        if (!$campaign->isPublic()) {
            return false;
        }

        return !$campaign->userIsMember();
    }
    /**
     *
     * Determine if a user can apply to a campaign
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function apply(?User $user, Campaign $campaign)
    {
        if (empty($user)) {
            return false;
        }

        if (!$campaign->isPublic() || !$campaign->is_open) {
            return false;
        }

        return !$campaign->userIsMember();
    }

    /**
     * Permission to view the members of a campaign
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function members(?User $user, Campaign $campaign)
    {
        if (!$user) {
            return false;
        }
        return (UserCache::user($user)->admin() || $this->checkPermission(CampaignPermission::ACTION_MEMBERS, $user, $campaign)) ||
            !($campaign->boosted() && $campaign->hide_members);
    }

    /**
     * Permission to view the campaign submissions
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function submissions(?User $user, Campaign $campaign)
    {
        return $user && UserCache::user($user)->admin();
    }

    /**
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function gallery(?User $user, Campaign $campaign): bool
    {
        return $user && (
            UserCache::user($user)->admin() || $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign)
        );
    }

    /**
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function relations(?User $user, Campaign $campaign): bool
    {
        return $user && UserCache::user($user)->admin();
    }


    /**
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function mapPresets(?User $user, Campaign $campaign): bool
    {
        return $user && UserCache::user($user)->admin();
    }

    /**
     * Check if a user can unboost a campaign
     * @param User|null $user
     * @param Campaign $campaign
     * @return bool
     */
    public function unboost(?User $user, Campaign $campaign): bool
    {
        $boost = $campaign->boosts->first();
        return $user && $boost && $boost->user_id === $user->id;
    }

    /**
     * @param int $action
     * @param User $user
     * @param Campaign|null $campaign
     * @return bool
     */
    protected function checkPermission(int $action, User $user, Campaign $campaign = null)
    {
        return EntityPermission::hasPermission(0, $action, $user, null, $campaign);
    }
}
