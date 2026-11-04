<?php

namespace App\Mcp\Services;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\EntityCache;
use App\Facades\EntityPermission;
use App\Facades\Module;
use App\Facades\Permissions;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class CampaignContext
{
    public function memberCampaigns(User $user)
    {
        return $user->campaigns()
            ->select('campaigns.id', 'campaigns.name', 'campaigns.slug')
            ->orderByDesc('campaigns.id');
    }

    public function campaign(User $user, int $campaignId): Campaign
    {
        $campaign = $this->memberCampaigns($user)->where('campaigns.id', $campaignId)->first();

        if (! $campaign) {
            throw new AuthorizationException;
        }

        Gate::forUser($user)->authorize('access', $campaign);

        CampaignLocalization::forceCampaign($campaign);
        CampaignCache::campaign($campaign);
        EntityCache::campaign($campaign);
        Module::campaign($campaign);
        UserCache::campaign($campaign)->user($user);
        EntityPermission::campaign($campaign)->user($user);
        Permissions::campaign($campaign)->user($user)->reload()->reset();

        return $campaign;
    }
}
