<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Jobs\Campaigns\NotifyAdmins;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;

class LeaveService
{
    use CampaignAware;
    use UserAware;

    public function leave(): void
    {
        /** @var ?CampaignUser $member */
        $member = CampaignUser::where('campaign_id', $this->campaign->id)
            ->where('user_id', $this->user->id)
            ->first();
        if (empty($member)) {
            throw new Exception(__('campaigns.leave.error'));
        }

        // Delete the member
        $member->delete();

        // Delete the member from all the roles in the campaign
        $roles = CampaignRoleUser::select('campaign_role_users.*')
            ->where('user_id', $this->user->id)
            ->leftJoin('campaign_roles as cr', 'cr.id', '=', 'campaign_role_users.campaign_role_id')
            ->where('cr.campaign_id', $this->campaign->id)
            ->get();
        foreach ($roles as $role) {
            $role->delete();
        }

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
        UserCache::user($this->user)->clear();
        CampaignCache::campaign($this->campaign)->clear();

        $this->user->log(UserLog::TYPE_CAMPAIGN_LEAVE);
    }
}
