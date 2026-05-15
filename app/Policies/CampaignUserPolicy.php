<?php

namespace App\Policies;

use App\Facades\Identity;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignUserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, CampaignUser $campaignUser, Campaign $campaign): bool
    {
        return $campaignUser->campaign_id === $campaign->id && $user->can('admin', $campaign);
    }

    public function update(User $user, CampaignUser $campaignUser): bool
    {
        // Don't allow updating if we are currently impersonating
        if (Identity::isImpersonating()) {
            return false;
        }

        $campaign = $campaignUser->campaign;

        // If user isn't an admin
        if (! $user->can('admin', $campaign)) {
            return false;
        }

        if ($user->id === $campaignUser->user_id) {
            return false;
        }

        // User isn't an admin, easy peasy
        if (! $campaignUser->user->can('admin', $campaign)) {
            return true;
        }

        // Check if the user was added to the admin role recently
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

        $campaign = $campaignUser->campaign;

        return $user->can('admin', $campaign)
            && ! $campaignUser->user->can('admin', $campaign)
            && ! $campaignUser->user->isBanned();
    }
}
