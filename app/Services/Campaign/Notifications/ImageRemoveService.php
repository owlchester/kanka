<?php

namespace App\Services\Campaign\Notifications;

use App\Jobs\Campaigns\NotifyAdmins;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class ImageRemoveService
{
    use CampaignAware;
    use EntityAware;

    /**
     * Notify the campaign admins that the image from an entity was forcibly deleted
     */
    public function notify(): void
    {
        $colour = 'yellow';
        $icon = 'eye-slash';
        $key = 'removed-image';

        NotifyAdmins::dispatch(
            $this->campaign,
            $key,
            $icon,
            $colour,
            [
                'entity' => $this->entity->name,
                'link' => $this->entity->url(),
            ]
        );
    }
}
