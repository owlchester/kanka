<?php

namespace App\Services\Tracking;

use App\Facades\AdCache;
use App\Models\Campaign;
use Carbon\Carbon;

class DatalayerService
{
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

    protected ?Campaign $campaign;

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

        if (auth()->check()) {
            $data['userType'] = 'registered';
            $data['userTier'] = ! empty(auth()->user()->pledge) ? auth()->user()->pledge : null;
            $data['userSubbed'] = ! empty(auth()->user()->pledge) ? 'true' : 'false';
            $data['userID'] = auth()->user()->id;

            if ($this->newCancelledSubscriber) {
                $data['newCancelled'] = '1';
            }
            if ($this->newAccount || $this->newSubscriber) {
                $data['userEmail'] = auth()->user()->email;
            }
        }

        // We only track if ads are shown or hidden on page that are set up to actually serve ads
        if (AdCache::canHaveAds()) {
            $data['showAds'] = $this->showAds();
        }

        return json_encode($data);
    }

    public function campaign(?Campaign $campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    protected function showAds(): bool
    {
        if ($this->campaign && $this->campaign->boosted()) {
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

        if (auth()->check()) {
            $this->group = auth()->user()->id % 2 == 0 ? 'a' : 'b';

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

    /**
     * @return $this
     */
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
     *
     * @return $this
     */
    public function newSubscriber(): self
    {
        $this->newSubscriber = true;

        return $this;
    }

    /**
     * Trigger the user as being newly cancelled
     *
     * @return $this
     */
    public function newCancelledSubscriber(): self
    {
        $this->newCancelledSubscriber = true;

        return $this;
    }

    /**
     * Set the new account as true
     *
     * @return $this
     */
    public function newAccount(): self
    {
        $this->newAccount = true;

        return $this;
    }
}
