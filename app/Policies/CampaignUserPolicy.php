<?php

namespace App\Policies;

use App\Facades\Identity;
use App\Facades\UserCache;
use App\Models\CampaignRoleUser;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignUserPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function update(User $user, CampaignUser $campaignUser): bool
    {
        // Don't allow updating if we are currently impersonating
        if (Identity::isImpersonating()) {
            return false;
        }
        if ($user->campaign->id !== $campaignUser->campaign_id) {
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

    public function delete(User $user, CampaignUser $campaignUser): bool
    {
        return $this->update($user, $campaignUser);
    }

    public function switch(User $user, CampaignUser $campaignUser): bool
    {
        if (Identity::isImpersonating()) {
            return false;
        }
        return $user->campaign->id == $campaignUser->campaign_id
            && $user->isAdmin() && !$campaignUser->user->isAdmin()
            && !$campaignUser->user->isBanned()
        ;
    }
}
