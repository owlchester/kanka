<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\Services\Campaign\NotificationService;
use App\User;
use Exception;

class CampaignService
{
    /**
     * The user's current Campaign
     */
    protected Campaign $campaign;

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function campaign()
    {
        return \App\Facades\CampaignLocalization::getCampaign();
    }

    public function name(): string
    {
        return $this->campaign->name;
    }

    /**
     * Notify the campaign admins that the campaign was forcibly hidden/made visible
     * @param Campaign $campaign
     * @throws Exception
     */
    public function hidden(Campaign $campaign)
    {
        $colour = 'green';
        $icon = 'eye';
        $key = 'shown';
        if ($campaign->isHidden()) {
            $colour = 'yellow';
            $icon = 'eye-slash';
            $key = 'hidden';
        }

        $this->notificationService
            ->campaign($campaign)
            ->notify(
                $key,
                $icon,
                $colour,
                [
                    'campaign' => $campaign->name,
                    'link' => $campaign->getMiddlewareLink()
                ]
            );
    }

    /**
     * Notify the campaign admins that the image from an entity was forcibly deleted
     * @param Campaign $campaign
     * @param Entity $entity
     * @throws Exception
     */
    public function removedImage(Campaign $campaign, Entity $entity)
    {
        $colour = 'yellow';
        $icon = 'eye-slash';
        $key = 'removed-image';

        $this->notificationService
            ->campaign($campaign)
            ->notify(
                $key,
                $icon,
                $colour,
                [
                    'entity' => $entity->name,
                    'link' => $entity->url(),
                ]
            );
    }

    /**
     * Is the user a member?
     * @return bool
     */
    public function member()
    {
        return $this->campaign()->member();
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->campaign()->roles;
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->campaign()->users;
    }
}
