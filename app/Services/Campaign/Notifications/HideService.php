<?php

namespace App\Services\Campaign\Notifications;

use App\Jobs\Campaigns\NotifyAdmins;
use App\Traits\CampaignAware;

class HideService
{
    use CampaignAware;

    /**
     * Notify the campaign admins that the campaign was forcibly hidden/made visible
     */
    public function notify(): void
    {
        $colour = 'green';
        $icon = 'eye';
        $key = 'shown';
        if ($this->campaign->isHidden()) {
            $colour = 'yellow';
            $icon = 'eye-slash';
            $key = 'hidden';
        }

        NotifyAdmins::dispatch(
            $this->campaign,
            $key,
            $icon,
            $colour,
            [
                'campaign' => $this->campaign->name,
                'link' => route('dashboard', $this->campaign),
            ]
        );
    }
}
