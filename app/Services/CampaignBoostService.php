<?php

namespace App\Services;

use App\Exceptions\Campaign\AlreadyBoostedException;
use App\Exceptions\Campaign\ExhaustedBoostsException;
use App\Exceptions\Campaign\ExhaustedSuperboostsException;
use App\Exceptions\TranslatableException;
use App\Models\CampaignBoost;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use App\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class CampaignBoostService
{
    use CampaignAware;
    use UserAware;

    /** @var string */
    protected string $action;

    /** @var bool If updating an existing boost to a superboost */
    protected bool $upgrade = false;

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
    public function boost(): void
    {
        if ($this->campaign->boosted() && !$this->upgrade) {
            throw new AlreadyBoostedException($this->campaign);
        }
        elseif ($this->user->availableBoosts() === 0) {
            throw new TranslatableException('settings/premium.exceptions.out-of-stock');
        }

        if ($this->action == 'superboost' && $this->user->availableBoosts() < ($this->upgrade ? 2 : 3)) {
            throw new ExhaustedSuperboostsException();
        }

        $amount = 1;
        if ($this->upgrade) {
            // Create two more
            $amount = 2;
            $this->user->log(UserLog::TYPE_CAMPAIGN_UPGRADE_BOOST);
        } elseif ($this->action === 'superboost') {
            // Create three
            $amount = 3;
            $this->user->log(UserLog::TYPE_CAMPAIGN_SUPERBOOST);
        } else {
            $this->user->log(UserLog::TYPE_CAMPAIGN_BOOST);
        }

        for ($i = 0; $i < $amount; $i++) {
            CampaignBoost::create([
                'campaign_id' => $this->campaign->id,
                'user_id' => $this->user->id
            ]);
        }
        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->saveQuietly();
    }

    public function premium(): void
    {
        if ($this->campaign->premium()) {
            throw new TranslatableException('settings/premium.exceptions.already');
        } elseif ($this->user->availableBoosts() < 1) {
            throw new TranslatableException('settings/premium.exceptions.out-of-stock');
        }

        $amount = 4;
        $this->user->log(UserLog::TYPE_CAMPAIGN_PREMIUM);

        for ($i = 0; $i < $amount; $i++) {
            CampaignBoost::create([
                'campaign_id' => $this->campaign->id,
                'user_id' => $this->user->id
            ]);
        }
        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->saveQuietly();
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
        if ($this->user) {
            foreach (auth()->user()->boosts()->where('campaign_id', $campaignBoost->campaign_id)->get() as $boost) {
                $boost->delete();
            }
            $this->user->log(UserLog::TYPE_CAMPAIGN_UNBOOST);
        }

        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->saveQuietly();

        return $this;
    }

    /**
     * Migrate a user away from the old boost concepts
     * @return void
     */
    public function migrate(): void
    {
        if ($this->user->isLegacyPatron()) {
            throw new TranslatableException('As a Patreon supporter, your account cannot switch to the new premium campaigns system. Please switch to supporting Kanka directly through the app to migrate to premium campaigns.');
        }

        $settings = $this->user->settings;

        if (!isset($settings['grandfathered_boost'])) {
            throw new TranslatableException('Your account has already switched to the premium campaign system.');
        }
        unset($settings['grandfathered_boost']);
        $this->user->settings = $settings;
        $this->user->saveQuietly();

        // Unboost everything
        foreach ($this->user->boosts()->with(['campaign', 'user'])->get() as $boost) {
            $this
                ->campaign($boost->campaign)
                ->unboost($boost);
        }
    }

    public function back(): void
    {
        $settings = $this->user->settings;
        $settings['grandfathered_boost'] = 1;
        $this->user->settings = $settings;
        $this->user->saveQuietly();

        foreach ($this->user->boosts()->with(['campaign', 'user'])->get() as $boost) {
            $this
                ->campaign($boost->campaign)
                ->unboost($boost);
        }
    }
}
