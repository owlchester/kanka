<?php

namespace App\Observers;

use App\Enums\UserAction;
use App\Models\CampaignInvite;
use Illuminate\Support\Str;

class CampaignInviteObserver
{
    public function creating(CampaignInvite $campaignInvite)
    {
        $campaignInvite->token = sha1(Str::random(50)) . time() . uniqid();
        $campaignInvite->is_active = true;
    }

    public function created(CampaignInvite $campaignInvite)
    {
        auth()->user()->campaignLog($campaignInvite->campaign_id, 'invites', 'created', ['id' => $campaignInvite->id]);
    }

    public function deleted(CampaignInvite $campaignInvite)
    {
        auth()->user()->campaignLog($campaignInvite->campaign_id, 'invites', 'deleted', ['id' => $campaignInvite->id]);
    }
}
