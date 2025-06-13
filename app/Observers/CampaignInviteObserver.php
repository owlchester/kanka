<?php

namespace App\Observers;

use App\Events\Campaigns\Invites\InviteCreated;
use App\Events\Campaigns\Invites\InviteDeleted;
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
        InviteCreated::dispatch($campaignInvite);
    }

    public function deleted(CampaignInvite $campaignInvite)
    {
        InviteDeleted::dispatch($campaignInvite);
    }
}
