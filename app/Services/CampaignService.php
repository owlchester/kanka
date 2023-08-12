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
     * @var Campaign|bool
     */
    protected $campaign = false;

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function campaign()
    {
        return \App\Facades\CampaignLocalization::getCampaign();
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->campaign->name;
    }

    /**
     * Switch campaigns
     * @param Campaign $campaign
     */
    public static function switchCampaign(Campaign $campaign)
    {
        session()->put('campaign_id', $campaign->id);
        $user = auth()->user();
        $user->last_campaign_id = $campaign->id;
        $user->saveQuietly();
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
     * @param Campaign $campaign
     * @throws Exception
     */
    public function removedImage(Campaign $campaign, Entity $entity)
    {
        $colour = 'yellow';
        $icon = 'eye-slash';
        $key = 'removed-image';

        $link = str_replace('campaign/0', 'en/campaign/' . $campaign->id, $entity->url());

        $this->notificationService
            ->campaign($campaign)
            ->notify(
                $key,
                $icon,
                $colour,
                [
                    'entity' => $entity->name,
                    'link' => $link,
                ]
            );
    }

    /**
     * Switch to the last campaign the user used
     * @param User|null $userParam
     */
    public static function switchToLast($userParam = null)
    {
        /** @var User|null $user */
        $user = $userParam ?: auth()->user();
        if (!$user) {
            return;
        }
        $last = $user->lastCampaign;
        if ($last) {
            self::switchCampaign($last);
        }
    }

    /**
     *
     */
    public static function switchToNext()
    {
        // Switch to the next available campaign?
        $member = CampaignUser::where('user_id', auth()->user()->id)->first();
        if ($member) {
            // Just switch to the first one available.
            self::switchCampaign($member->campaign);
        } else {
            // Need to create a new campaign
            session()->forget('campaign_id');
        }
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
