<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Jobs\Campaigns\NotifyAdmins;
use App\Models\CampaignUser;
use App\Models\UserLog;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;

class LeaveService
{
    use CampaignAware;
    use UserAware;

    public function leave(): void
    {
        /** @var CampaignUser|null $member */
        $member = CampaignUser::where('campaign_id', $this->campaign->id)
            ->where('user_id', $this->user->id)
            ->first();
        if (empty($member)) {
            throw new Exception(__('campaigns.leave.error'));
        }

        // Delete the member
        $member->delete();

        // Notify admins
        NotifyAdmins::dispatch(
            $this->campaign,
            'leave',
            'user',
            'yellow',
            [
                'user' => $this->user->name,
                'campaign' => $this->campaign->name,
                'link' => route('dashboard', $this->campaign),
            ]
        );

        // Clear cache
        UserCache::user($this->user)->clearCampaigns();
        CampaignCache::campaign($this->campaign)->clearRoles()->clearAdmins();

        $this->user->log(UserLog::TYPE_CAMPAIGN_LEAVE);
    }
}
