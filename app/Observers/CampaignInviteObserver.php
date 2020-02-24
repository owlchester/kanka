<?php

namespace App\Observers;

use App\Jobs\Emails\InvitationEmailJob;
use App\Mail\CampaignInviteMail;
use App\Models\CampaignInvite;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CampaignInviteObserver
{
    /**
     * @param CampaignInvite $campaignInvite
     */
    public function created(CampaignInvite $campaignInvite)
    {
        // Send email to the new user too join
        if ($campaignInvite->type == 'email') {
            InvitationEmailJob::dispatch($campaignInvite, auth()->user(), app()->getLocale());
        }
    }

    /**
     * @param CampaignInvite $campaignInvite
     */
    public function creating(CampaignInvite $campaignInvite)
    {
        $campaignInvite->token = sha1(Str::random(50)) . time() . uniqid();
        $campaignInvite->is_active = true;
        $campaignInvite->created_by = Auth::user()->id;
        $campaignInvite->campaign_id = Auth::user()->campaign->id;

        if ($campaignInvite->type == 'link') {
            $campaignInvite->email = '';
        } else {
            $campaignInvite->validity = 1;
        }
    }
}
