<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Jobs\Emails\InvitationEmailJob;
use App\Models\CampaignInvite;
use Illuminate\Support\Str;

class CampaignInviteObserver
{
    /**
     * @param CampaignInvite $campaignInvite
     */
    public function created(CampaignInvite $campaignInvite)
    {
        // Send email to the new user to join
        if ($campaignInvite->isEmail()) {
            InvitationEmailJob::dispatch($campaignInvite, auth()->user(), app()->getLocale());
        }
    }

    /**
     * @param CampaignInvite $campaignInvite
     */
    public function creating(CampaignInvite $campaignInvite)
    {
        $campaign = CampaignLocalization::getCampaign();
        $campaignInvite->token = sha1(Str::random(50)) . time() . uniqid();
        $campaignInvite->is_active = true;
        $campaignInvite->created_by = auth()->user()->id;
        $campaignInvite->campaign_id = $campaign->id;

        if ($campaignInvite->isEmail()) {
            $campaignInvite->validity = 1;
        } else {
            $campaignInvite->email = '';
        }
    }
}
