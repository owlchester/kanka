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
    /** @var Campaign */
    protected $campaign;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param User|null $user
     * @return CampaignBoost
     * @throws AlreadyBoostedException
     * @throws ExhaustedBoostsException
     */
    public function boost(User $user = null): CampaignBoost
    {
        if ($this->campaign->boosted()) {
            throw new AlreadyBoostedException($this->campaign);
        }

        if ($user === null) {
            $user = Auth::user();
        }

        if ($user->availableBoosts() === 0) {
            throw new ExhaustedBoostsException();
        }

        $boost = CampaignBoost::create([
            'campaign_id' => $this->campaign->id,
            'user_id' => $user->id
        ]);

        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->withObservers = false;
        $this->campaign->save();

        return $boost;
    }

    /**
     * Unboost a campaign
     * @param CampaignBoost $campaignBoost
     * @return $this
     * @throws \Exception
     */
    public function unboost(CampaignBoost $campaignBoost): self
    {
        $campaignBoost->delete();

        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->withObservers = false;
        $this->campaign->save();

        return $this;
    }
}
