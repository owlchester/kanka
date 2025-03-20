<?php

namespace App\View\Components\Ads;

use App\Facades\AdCache;
use App\Models\Ad;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Native extends Component
{
    public User $user;

    public Ad $ad;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $section,
        public ?Campaign $campaign = null,
    ) {
        if (auth()->check()) {
            $this->user = auth()->user();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (! $this->noAds()) {
            return '';
        }
        $this->ad = AdCache::get();

        return view('components.ads.native');
    }

    protected function noAds(): bool
    {
        // No admin panel set up, no ads possible, since the admin project provides the tables
        if (! config('app.admin')) {
            return false;
        }
        // If we provided an ad test, override that
        if (request()->has('_adtest') && auth()->user()->hasRole('admin')) {
            return AdCache::test($this->section, request()->get('_adtest'));
        }
        // If the section has no ads, don't try and show anything
        if (! AdCache::has($this->section)) {
            return false;
        }
        // Force ads displayed
        if (request()->get('_boost') === '0') {
            return true;
        }

        if (isset($this->user)) {
            // Subscribed users don't have ads
            if ($this->user->isSubscriber()) {
                return false;
            }
            // User has been created less than 24 hours ago
            if ($this->user->created_at->diffInHours(Carbon::now()) < 24) {
                return false;
            }
        }

        // Premium campaigns don't either have ads displayed to their members
        return isset($this->campaign) && ! $this->campaign->boosted();
    }
}
