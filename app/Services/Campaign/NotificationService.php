<?php

namespace App\Services\Campaign;

use App\Notifications\Header;
use App\Traits\CampaignAware;

class NotificationService
{
    use CampaignAware;

    public function notify(string $key, string $icon, string $colour, array $params = []): void
    {
        $this->campaign->notifyAdmins(
            new Header('campaign.' . $key, $icon, $colour, $params)
        );
    }
}
