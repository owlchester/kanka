<?php

namespace App\Services;

use App\Jobs\Campaigns\NotifyAdmins;
use App\Models\Campaign;
use App\Models\Entity;
use Exception;

class CampaignService
{
    protected Campaign $campaign;

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

        NotifyAdmins::dispatch(
            $campaign,
            $key,
            $icon,
            $colour,
            [
                'campaign' => $campaign->name,
                'link' => route('dashboard', $campaign)
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


        NotifyAdmins::dispatch(
            $campaign,
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
