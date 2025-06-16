<?php

namespace App\Services\Tracking;

use App\Facades\AdCache;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Carbon\Carbon;

class DatalayerService
{
    use CampaignAware;
    use UserAware;

    /** Group name: a|b */
    protected string $group;

    /** @var array Extra parameters to pass */
    protected array $additional = [];

    /** @var bool If the user is newly created */
    protected bool $newAccount = false;

    /** @var bool If the user is newly registered */
    protected bool $newSubscriber = false;

    /** @var bool If the user is newly cancelled */
    protected bool $newCancelledSubscriber = false;

    public function base(): string
    {
        $data = array_merge([
            'userType' => 'visitor',
            'userGroup' => $this->userGroup(),
            'userTier' => null,
            'userSubbed' => false,
            'route' => $this->route(),
            'newAccount' => $this->newAccount ? '1' : '0',
            'newSubscriber' => $this->newSubscriber ? '1' : '0',
            'userID' => null,
        ], $this->additional);

        if (isset($this->user)) {
            $data['userType'] = 'registered';
            $data['userTier'] = ! empty($this->user->pledge) ? $this->user->pledge : null;
            $data['userSubbed'] = ! empty($this->user->pledge) ? 'true' : 'false';
            $data['userID'] = $this->user->id;

            if ($this->newCancelledSubscriber) {
                $data['newCancelled'] = '1';
            }
            if ($this->newAccount || $this->newSubscriber) {
                $data['userEmail'] = $this->user->email;
            }
        }

        // We only track if ads are shown or hidden on page that are set up to actually serve ads
        if (AdCache::canHaveAds()) {
            $data['showAds'] = $this->showAds();
        }

        return json_encode($data);
    }

    protected function showAds(): bool
    {
        if (isset($this->campaign) && $this->campaign->boosted()) {
            return false;
            //        } elseif (!AdCache::canHaveAds()) {
            //            return false;
        } elseif (auth()->guest()) {
            return true;
        } elseif (auth()->user()->isSubscriber()) {
            return false;
        }

        return auth()->user()->created_at->diffInHours(Carbon::now()) > 24;
    }

    public function userGroup(): string
    {
        if (isset($this->group)) {
            return $this->group;
        }
        // Set in session? Use that
        if (session()->has('user_group')) {
            $this->group = session()->get('user_group');

            return $this->group;
        }

        if (isset($this->user)) {
            $this->group = $this->user->id % 2 == 0 ? 'a' : 'b';

            return $this->group;
        }

        // Unlogged user, use one from the session
        $this->group = mt_rand(0, 1) === 0 ? 'a' : 'b';
        session()->put('user_group', $this->group);

        return $this->group;
    }

    public function groupB(): bool
    {
        return $this->userGroup() === 'b';
    }

    public function add(string $key, mixed $value): self
    {
        $this->additional[$key] = $value;

        return $this;
    }

    protected function route(): string
    {
        if (empty(request()->route())) {
            return '';
        }

        return (string) request()->route()->getName();
    }

    /**
     * Set the new subscriber as true
     */
    public function newSubscriber(): self
    {
        $this->newSubscriber = true;

        return $this;
    }

    /**
     * Trigger the user as being newly cancelled
     */
    public function newCancelledSubscriber(): self
    {
        $this->newCancelledSubscriber = true;

        return $this;
    }

    /**
     * Set the new account as true
     */
    public function newAccount(): self
    {
        $this->newAccount = true;

        return $this;
    }
}
