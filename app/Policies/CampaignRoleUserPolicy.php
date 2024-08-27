<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Traits\AdminPolicyTrait;
use App\Models\User;
use App\Models\CampaignRoleUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRoleUserPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function view(User $user, CampaignRoleUser $campaignRoleUser, Campaign $campaign): bool
    {
        return $campaignRoleUser->campaignRole->campaign_id === $campaign->id && UserCache::user($user)->admin();
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, CampaignRoleUser $campaignRoleUser): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user): bool
    {
        return UserCache::user($user)->admin();
    }
}
