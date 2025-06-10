<?php

namespace App\Services\Users;

use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignUser;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

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

    /**
     * List of user campaigns thar aren't the current one
     */
    public function campaigns(): array
    {
        return $this
            ->user
            ->campaigns()
            ->whereNotIn('campaign_id', [$this->campaign->id])
            ->pluck('campaigns.name', 'campaigns.id')
            ->toArray();
    }

    /**
     * List of campaigns the user is the owner and last member of. This is used for the purge warning emails
     */
    public function flaggedCampaigns(): array
    {
        $campaigns = [];
        /** @var Campaign[] $userCampaigns */
        $userCampaigns = $this->user->campaigns()->with(['roles', 'roles.users'])->get();
        foreach ($userCampaigns as $campaign) {
            /** @var ?CampaignRole $adminRole */
            $adminRole = $campaign->roles->where('is_admin', true)->first();
            if (! $adminRole) {
                continue;
            }

            // If the user isn't in the admin
            $isAdmin = false;
            foreach ($adminRole->users as $member) {
                if ($member->user_id === $this->user->id) {
                    $isAdmin = true;
                }
            }

            if (! $isAdmin || $adminRole->users->count() > 1) {
                continue;
            }

            // The user is the only admin
            $campaigns[] = $campaign;
        }

        return $campaigns;
    }
}
