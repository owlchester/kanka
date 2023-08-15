<?php

namespace App\Services\Campaign;

use App\Facades\UserCache;
use App\Models\CampaignUser;
use App\Models\UserLog;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;

class LeaveService
{
    use CampaignAware;
    use UserAware;

    protected NotificationService $notificationService;

    public function __construct(
        NotificationService $notificationService
    ) {
        $this->notificationService = $notificationService;
    }

    public function leave(): void
    {
        /** @var CampaignUser|null $member */
        $member = CampaignUser::where('campaign_id', $this->campaign->id)
            ->where('user_id', $this->user->id)
            ->first();
        if (empty($member)) {
            throw new Exception(__('campaigns.leave.error'));
        }
        // Delete user from roles.
        // Todo: don't we have this on the user themselves?
        /*foreach ($this->campaign->roles as $role) {
            foreach ($role->users as $user) {
                if ($user->user_id == $this->user->id) {
                    $user->delete();
                }
            }
        }*/

        // Delete the member
        $member->delete();

        // Notify admins
        $this->notificationService
            ->campaign($this->campaign)
            ->notify(
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
        UserCache::clearCampaigns();
        $this->user->log(UserLog::TYPE_CAMPAIGN_LEAVE);
    }
}
