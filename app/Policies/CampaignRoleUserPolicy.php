<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRoleUserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, CampaignRoleUser $campaignRoleUser, Campaign $campaign): bool
    {
        return $campaignRoleUser->campaignRole->campaign_id === $campaign->id && $user->can('admin', $campaign);
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $user->can('admin', $campaign);
    }

    public function update(User $user, CampaignRoleUser $campaignRoleUser): bool
    {
        return $user->can('admin', $campaignRoleUser->campaignRole->campaign);
    }

    public function delete(User $user, CampaignRoleUser $campaignRoleUser, CampaignRole $campaignRole): bool
    {
        return $user->can('admin', $campaignRole->campaign);
    }
}
