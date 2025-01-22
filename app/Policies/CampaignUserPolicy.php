<?php

namespace App\Policies;

use App\Facades\Identity;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Traits\AdminPolicyTrait;
use App\Models\User;
use App\Models\CampaignUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignUserPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function view(User $user, CampaignUser $campaignUser, Campaign $campaign): bool
    {
        return $campaignUser->campaign_id === $campaign->id && $user->isAdmin();
    }
    public function update(User $user, CampaignUser $campaignUser): bool
    {
        // Don't allow updating if we are currently impersonating
        if (Identity::isImpersonating()) {
            return false;
        }

        // If user isn't in admin
        if (!$user->isAdmin()) {
            return false;
        }

        if ($user->id === $campaignUser->user_id) {
            return false;
        }

        // User isn't an admin, easy peasy
        if (!$campaignUser->user->isAdmin()) {
            return true;
        }

        // Check if the user was added to the admin role recently
        /** @var CampaignRoleUser $adminRole */
        $adminRole = UserCache::adminRole();
        $role = $campaignUser->user->campaignRoleUser->where('campaign_role_id', $adminRole['id'])->first();
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
        return $user->isAdmin()
            && !$campaignUser->user->isAdmin()
            && !$campaignUser->user->isBanned()
        ;
    }
}
