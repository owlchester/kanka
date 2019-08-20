<?php


namespace App\Services;


use App\Models\Campaign;
use App\Models\CampaignFollower;
use App\User;

class CampaignFollowService
{
    /**
     * Update a user's following of a campaign.
     * @param Campaign $campaign
     * @param User $user
     * @return bool If true, the user is following the campaign
     */
    public function update(Campaign $campaign, User $user): bool
    {
        if ($campaign->isFollowing()) {
            if ($this->remove($campaign, $user)) {
                return false;
            }
            return true;
        }
        if ($this->add($campaign, $user)) {
            return true;
        }
        return false;
    }

    /**
     * @param Campaign $campaign
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function remove(Campaign $campaign, User $user): bool
    {
        /** @var CampaignFollower $follow */
        $follow = CampaignFollower::where([
            'campaign_id' => $campaign->id,
            'user_id' => $user->id
        ])->first();

        if (empty($follow)) {
            return false;
        }

        return $follow->delete();
    }

    /**
     * @param Campaign $campaign
     * @param User $user
     * @return bool
     */
    public function add(Campaign $campaign, User $user): bool
    {
        $follow = new CampaignFollower();
        $follow->campaign_id = $campaign->id;
        $follow->user_id = $user->id;
        return $follow->save();
    }
}