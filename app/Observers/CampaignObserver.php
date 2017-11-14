<?php

namespace App\Observers;

use App\Campaign;
use App\CampaignUser;
use App\Services\CampaignService;
use App\Services\ImageService;
use App\Services\StarterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class CampaignObserver
{
    /**
     * @param Campaign $campaign
     */
    public function saving(Campaign $campaign)
    {
        $campaign->slug = str_slug($campaign->name, '');

        if (empty($campaign->locale)) {
            $campaign->locale = 'en';
        }

        // Purity text
        $campaign->description = Purify::clean($campaign->description);

        // Handle image. Let's use a service for this.
        ImageService::handle($campaign, 'campaigns');
    }

    /**
     * @param Campaign $campaign
     */
    public function saved(Campaign $campaign)
    {
    }

    /**
     * @param Campaign $campaign
     */
    public function created(Campaign $campaign)
    {
        $role = new CampaignUser([
            'user_id' => Auth::user()->id,
            'campaign_id' => $campaign->id,
            'role' => 'owner'
        ]);
        $role->save();

        // If it's the user's first campaign, let's help out a bit.
        $first = !Session::has('campaign_id');
        Session::put('campaign_id', $campaign->id);

        // Make sure we save the last campaign id to avoid infinite loops
        $user = Auth::user();
        $user->last_campaign_id = $campaign->id;
        $user->save();

        if ($first) {
            StarterService::generateBoilerplate($campaign);
        }
    }

    /**
     * @param Campaign $campaign
     */
    public function creating(Campaign $campaign)
    {
        $campaign->join_token = $campaign->getToken();
    }

    /**
     * @param Campaign $campaign
     */
    public function deleted(Campaign $campaign)
    {
        ImageService::cleanup($campaign);
    }

    /**
     * Deleting the campaign
     *
     * @param Campaign $campaign
     */
    public function deleting(Campaign $campaign)
    {
        foreach ($campaign->members as $member) {
            $member->delete();
        }
    }
}
