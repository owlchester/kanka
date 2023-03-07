<?php

namespace App\Services;

use App\Facades\SingleUserCache;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Models\UserLog;
use App\Notifications\Header;
use App\User;
use Exception;

class CampaignService
{
    /**
     * Switch campaigns
     * @param Campaign $campaign
     */
    public static function switchCampaign(Campaign $campaign)
    {
        session()->put('campaign_id', $campaign->id);
        /** @var User $user */
        $user = auth()->user();
        $user->last_campaign_id = $campaign->id;
        $user->saveQuietly();
    }

    /**
     * Leave a campaign
     * @param Campaign $campaign
     * @throws Exception
     */
    public function leave(Campaign $campaign)
    {
        /** @var CampaignUser|null $member */
        $member = CampaignUser::where('campaign_id', $campaign->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if (empty($member)) {
            // Shouldn't be able to leave a campaign they aren't a part of...?
            // Switch to the next available campaign?
            /** @var CampaignUser|null $member */
            $member = CampaignUser::where('user_id', auth()->user()->id)->first();
            if ($member) {
                // Just switch to the first one available.
                self::switchCampaign($member->campaign);
            } else {
                // Need to create a new campaign
                session()->forget('campaign_id');
            }

            throw new Exception(__('campaigns.leave.error'));
        }
        // Delete user from roles
        foreach ($campaign->roles as $role) {
            foreach ($role->users as $user) {
                if ($user->user_id == auth()->user()->id) {
                    $user->delete();
                }
            }
        }

        // Delete the member
        $member->delete();

        // Notify admins
        $this->notify(
            $campaign,
            'leave',
            'user',
            'yellow',
            [
                'user' => auth()->user()->name,
                'campaign' => $campaign->name,
                'link' => route('dashboard', $campaign->id)
            ]
        );

        // Clear cache
        SingleUserCache::clearCampaigns();
        auth()->user()->log(UserLog::TYPE_CAMPAIGN_LEAVE);

        self::switchToNext();
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

        $this->notify(
            $campaign,
            $key,
            $icon,
            $colour,
            [
                'campaign' => $campaign->name,
                'link' => route('dashboard', $campaign->id)
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
        if ($last && !session()->has('campaign_id')) {
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
     * @param Campaign $campaign
     * @param string $key
     * @param string $icon
     * @param string $colour
     * @param array $params
     */
    public function notify(Campaign $campaign, string $key, string $icon, string $colour, array $params = []): void
    {
        // Notify all admins
        $campaign->notifyAdmins(
            new Header('campaign.' . $key, $icon, $colour, $params)
        );
    }

    /**
     * @param Campaign $campaign
     * @throws Exception
     */
    public function delete(Campaign $campaign)
    {
        auth()->user()->log(UserLog::TYPE_CAMPAIGN_DELETE);
        $campaign->delete();
        CampaignService::switchToNext();
    }
}
