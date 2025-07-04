<?php

namespace App\Services\Campaign;

use App\Events\Subscriptions\Boost;
use App\Events\Subscriptions\Disable;
use App\Events\Subscriptions\Premium;
use App\Events\Subscriptions\SuperBoost;
use App\Events\Subscriptions\Upgrade;
use App\Exceptions\Campaign\AlreadyBoostedException;
use App\Exceptions\Campaign\ExhaustedBoostsException;
use App\Exceptions\Campaign\ExhaustedSuperboostsException;
use App\Exceptions\TranslatableException;
use App\Jobs\Campaigns\NotifyAdmins;
use App\Models\CampaignBoost;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class BoostService
{
    use CampaignAware;
    use UserAware;

    protected string $action;

    /** @var bool If updating an existing boost to a superboost */
    protected bool $upgrade = false;

    public function action(string $action = 'boost'): self
    {
        $this->action = $action;

        return $this;
    }

    public function upgrade(): self
    {
        $this->upgrade = true;

        return $this;
    }

    /**
     * @throws AlreadyBoostedException
     * @throws ExhaustedBoostsException
     */
    public function boost(): void
    {
        if ($this->campaign->boosted() && ! $this->upgrade) {
            throw new AlreadyBoostedException($this->campaign);
        } elseif ($this->user->availableBoosts() === 0) {
            throw new TranslatableException('settings/premium.exceptions.out-of-stock');
        }

        if ($this->action == 'superboost' && $this->user->availableBoosts() < ($this->upgrade ? 2 : 3)) {
            throw new ExhaustedSuperboostsException;
        }

        // How many boosters we need to create in the table. This is silly and could use some refactoring.
        $amount = 1;
        if ($this->upgrade) {
            $amount = 2;
            Upgrade::dispatch($this->campaign, $this->user);
        } elseif ($this->action === 'superboost') {
            $amount = 3;
            SuperBoost::dispatch($this->campaign, $this->user);
        } else {
            Boost::dispatch($this->campaign, $this->user);
        }

        for ($i = 0; $i < $amount; $i++) {
            CampaignBoost::create([
                'campaign_id' => $this->campaign->id,
                'user_id' => $this->user->id,
            ]);
        }
        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->saveQuietly();

        $key = $this->action === 'superboost' ? 'boost.superboost' : 'boost.add';
        $this->notify($key);
    }

    public function premium(): void
    {
        if ($this->campaign->premium()) {
            throw new TranslatableException('settings/premium.exceptions.already');
        } elseif ($this->user->availableBoosts() < 1) {
            throw new TranslatableException('settings/premium.exceptions.out-of-stock');
        }

        $amount = 4;
        Premium::dispatch($this->campaign, $this->user);

        for ($i = 0; $i < $amount; $i++) {
            CampaignBoost::create([
                'campaign_id' => $this->campaign->id,
                'user_id' => $this->user->id,
            ]);
        }
        $this->campaign->boost_count = $this->campaign->boosts()->count();
        $this->campaign->saveQuietly();

        $this->notify('premium.add');
    }

    /**
     * Unboost a campaign
     *
     * @throws \Exception
     */
    public function unboost(CampaignBoost $campaignBoost): self
    {
        $campaignBoost->delete();

        // Delete other boosts on the same campaign if the user is superboosting
        if (isset($this->user)) {
            foreach ($this->user->boosts()->where('campaign_id', $campaignBoost->campaign_id)->get() as $boost) {
                $boost->delete();
            }
            Disable::dispatch($this->campaign, $this->user);
        }
        $boostCount = $this->campaign->boosts()->count();
        $this->campaign->boost_count = $boostCount;
        $this->campaign->is_discreet = false;

        $this->campaign->saveQuietly();

        if (isset($this->user)) {
            $key = $this->user->hasBoosterNomenclature() ? 'boost.remove' : 'premium.remove';
            $this->notify($key);
        }

        return $this;
    }

    /**
     * Migrate a user away from the old boost concepts
     */
    public function migrate(): void
    {
        if ($this->user->isLegacyPatron()) {
            throw new TranslatableException('As a Patreon supporter, your account cannot switch to the new premium campaigns system. Please switch to supporting Kanka directly through the app to migrate to premium campaigns.');
        }

        $settings = $this->user->settings;

        if (! isset($settings['grandfathered_boost'])) {
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

    /**
     * Dispatch a job to notify all campaign admins
     */
    protected function notify(string $key): self
    {
        NotifyAdmins::dispatch(
            $this->campaign,
            $key,
            'rocket',
            'maroon',
            [
                'user' => $this->user->name,
                'campaign' => $this->campaign->name,
                'link' => route('dashboard', $this->campaign),
            ]
        );

        return $this;
    }
}
