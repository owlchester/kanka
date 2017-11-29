<?php

namespace App\Observers;

use App\Mail\CampaignInviteMail;
use App\Models\CampaignInvite;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CampaignInviteObserver
{
    /**
     * @param CampaignInvite $campaignInvite
     */
    public function created(CampaignInvite $campaignInvite)
    {
        // Send email to the new user too join
        Mail::to($campaignInvite->email)->send(
            new CampaignInviteMail(
                Auth::user(),
                $campaignInvite
            )
        );
    }

    /**
     * @param CampaignInvite $campaignInvite
     */
    public function creating(CampaignInvite $campaignInvite)
    {
        $campaignInvite->token = sha1(str_random(50)) . time() . uniqid();
        $campaignInvite->is_active = true;
        $campaignInvite->created_by = Auth::user()->id;
        $campaignInvite->campaign_id = Auth::user()->campaign->id;
    }
}
