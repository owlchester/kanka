<?php

namespace App\Services\Campaign;

use App\Models\CampaignFollower;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class FollowService
{
    use CampaignAware;
    use UserAware;

    /**
     * Update a user's following of a campaign.
     *
     * @return bool If true, the user is following the campaign
     */
    public function update(): bool
    {
        if ($this->campaign->isFollowing()) {
            return ! $this->remove();
        }

        return $this->add();
    }

    public function remove(): bool
    {
        /** @var ?CampaignFollower $follow */
        $follow = CampaignFollower::where([
            'campaign_id' => $this->campaign->id,
            'user_id' => $this->user->id,
        ])->first();

        if (empty($follow)) {
            return false;
        }
        $follow->delete();

        return true;
    }

    public function add(): bool
    {
        $follow = new CampaignFollower;
        $follow->campaign_id = $this->campaign->id;
        $follow->user_id = $this->user->id;

        return $follow->save();
    }
}
