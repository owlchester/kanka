<?php

namespace App\Observers;

use App\Enums\UserAction;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Jobs\CampaignRoleUserJob;
use App\Models\CampaignRoleUser;

class CampaignRoleUserObserver
{
    public function created(CampaignRoleUser $campaignRoleUser)
    {
        CampaignRoleUserJob::dispatch($campaignRoleUser, true);
        UserCache::user($campaignRoleUser->user)->clear();

        auth()->user()->campaignLog($campaignRoleUser->campaignRole->campaign_id, 'user-role', 'created', [
            'user' => $campaignRoleUser->user->name,
            'user_id' => $campaignRoleUser->user_id,
            'role' => $campaignRoleUser->campaignRole->name,
            'role_id' => $campaignRoleUser->campaign_role_id,
        ]);
    }

    public function deleted(CampaignRoleUser $campaignRoleUser)
    {
        CampaignRoleUserJob::dispatch($campaignRoleUser, false);
        UserCache::user($campaignRoleUser->user)->clear();
        CampaignCache::campaign($campaignRoleUser->campaignRole->campaign)->clear();

        auth()->user()->campaignLog($campaignRoleUser->campaignRole->campaign_id, 'user-role', 'deleted', [
            'user' => $campaignRoleUser->user->name,
            'user_id' => $campaignRoleUser->user_id,
            'role' => $campaignRoleUser->campaignRole->name,
            'role_id' => $campaignRoleUser->campaign_role_id,
        ]);
    }
}
