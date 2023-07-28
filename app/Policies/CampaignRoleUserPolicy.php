<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignRoleUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRoleUserPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $user->campaign->id == $campaign->id && $this->isAdmin($user);
    }

    public function update(User $user, CampaignRoleUser $campaignRoleUser): bool
    {
        return $user->campaign->id == $campaignRoleUser->campaign->id && $this->isAdmin($user);
    }

    public function delete(User $user): bool
    {
        return UserCache::user($user)->admin();
    }
}
