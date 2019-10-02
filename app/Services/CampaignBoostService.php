<?php

namespace App\Services;

use App\Exceptions\Campaign\AlreadyBoostedException;
use App\Exceptions\Campaign\ExhaustedBoostsException;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\User;
use Illuminate\Support\Facades\Auth;

class CampaignBoostService
{
    /**
     * @param Campaign $campaign
     * @param User|null $user
     * @return CampaignBoost
     * @throws AlreadyBoostedException
     * @throws ExhaustedBoostsException
     */
    public function boost(Campaign $campaign, User $user = null): CampaignBoost
    {
        if ($campaign->boosted()) {
            throw new AlreadyBoostedException();
        }

        if ($user === null) {
            $user = Auth::user();
        }

        if ($user->availableBoosts() === 0) {
            throw new ExhaustedBoostsException();
        }

        return CampaignBoost::create([
            'campaign_id' => $campaign->id,
            'user_id' => $user->id
        ]);
    }
}
