<?php

namespace App\Services\Users;

use App\Models\CampaignUser;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class CampaignService
{
    use CampaignAware;
    use UserAware;

    /**
     * Set a campaign as the user's "current" campaign
     */
    public function set(): self
    {
        session()->put('campaign_id', $this->campaign->id);
        $this->user->last_campaign_id = $this->campaign->id;
        $this->user->saveQuietly();

        return $this;
    }

    public function last(): self
    {
        if (! isset($this->user)) {
            return $this;
        }
        $last = $this->user->lastCampaign;
        if (! $last) {
            return $this;
        }

        return $this->campaign($last)->set();
    }

    public function next(): self
    {
        // Switch to the next available campaign?
        $member = CampaignUser::where('user_id', auth()->user()->id)->first();
        if ($member && $member->campaign) {
            // Just switch to the first one available.
            return $this->campaign($member->campaign)->set();
        } else {
            // Need to create a new campaign
            session()->forget('campaign_id');
        }

        return $this;
    }
}
