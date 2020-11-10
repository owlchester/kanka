<?php

namespace App\Services;

use App\Exceptions\Campaign\AlreadyBoostedException;
use App\Exceptions\Campaign\ExhaustedBoostsException;
use App\Exceptions\Campaign\ExhaustedSuperboostsException;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\User;
use Illuminate\Support\Facades\Auth;

class CampaignBoostService
{
    /** @var Campaign */
    protected $campaign;

    /** @var string */
    protected $action;

    /** @var bool If updating an existing boost to a superboost */
    protected $upgrade = false;

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
     * @param string $action
     * @return $this
     */
    public function action(string $action = 'boost'): self
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return $this
     */
    public function upgrade(): self
    {
        $this->upgrade = true;
        return $this;
    }

    /**
     * @param User|null $user
     * @throws AlreadyBoostedException
     * @throws ExhaustedBoostsException
     */
    public function boost(User $user = null): void
    {
        if ($this->campaign->boosted() && !$this->upgrade) {
            throw new AlreadyBoostedException($this->campaign);
        }

        if ($user === null) {
            $user = Auth::user();
        }

        if ($user->availableBoosts() === 0) {
            throw new ExhaustedBoostsException();
        }

        if ($this->action == 'superboost' && $user->availableBoosts() < ($this->upgrade ? 2 : 3)) {
            throw new ExhaustedSuperboostsException();
        }

        $amount = 1;
        if ($this->upgrade) {
            // Create two more
            $amount = 2;
        }
        elseif ($this->action === 'superboost') {
            // Create three
            $amount = 3;
        }

        for ($i = 0; $i < $amount; $i++) {
            CampaignBoost::create([
                'campaign_id' => $this->campaign->id,
                'user_id' => $user->id
            ]);
        }
        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->withObservers = false;
        $this->campaign->save();
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

        // Delete other boosts on the same campaign if the user is superboosting
        foreach (auth()->user()->boosts()->where('campaign_id', $campaignBoost->campaign_id)->get() as $boost) {
            $boost->delete();
        }

        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->withObservers = false;
        $this->campaign->save();

        return $this;
    }
}
