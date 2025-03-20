<?php

namespace App\Observers;

use App\Models\CampaignInvite;
use Illuminate\Support\Str;

class CampaignInviteObserver
{
    public function creating(CampaignInvite $campaignInvite)
    {
        $campaignInvite->token = sha1(Str::random(50)) . time() . uniqid();
        $campaignInvite->is_active = true;
    }
}
