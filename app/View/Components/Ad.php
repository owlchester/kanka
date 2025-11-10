<?php

namespace App\View\Components;

use App\Facades\AdCache;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ad extends Component
{
    protected User $user;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $section = null,
        public ?Campaign $campaign = null,
        public bool $script = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (auth()->check()) {
            $this->user = auth()->user();
        }

        return view('components.ad');
    }

    /**
     * Determine if ads should be displayed
     */
    public function shouldRender(): bool
    {
        // If we don't have free enabled, then we don't have any ads to show
        $provider = config('ads.provider');
        if (empty($provider)) {
            return false;
        }

        // If requesting a section that isn't set up, don't show
        $key = 'ads.' . $provider . '.tags.' . $this->section;
        if (! empty($this->section) && empty(config($key))) {
            // dump("Unknown ad tag " . $key);
            return false;
        }
        if (! AdCache::canHaveAds()) {
            // Using the adless middleware to define routes that have no ads (ie settings)
            return false;
        }
        // Parameter to force ads to be displayed
        if (request()->has('_showads')) {
            return true;
        }

        // Temp workaround for venatus to fix their ads
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

        // Premium campaigns don't have ads displayed to their members
        return ! empty($this->campaign) && ! $this->campaign->boosted();
    }
}
