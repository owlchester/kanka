<?php

namespace App\View\Components;

use App\Facades\AdCache;
use App\Models\Campaign;
use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ad extends Component
{
    public ?string $section;
    public ?Campaign $campaign;
    protected User $user;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $section = null,
        Campaign $campaign = null,
    ) {
        $this->section = $section;
        $this->campaign = $campaign;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (auth()->check()) {
            $this->user = auth()->user();
        }
        if (!$this->hasAd()) {
            return '';
        }
        return view('components.ad');
    }

    /**
     * Determine if ads should be displayed
     */
    protected function hasAd(): bool
    {
        // If we don't have venatus enabled, then we don't have any ads to show
        if (!config('tracking.venatus.enabled')) {
            return false;
        }

        // If requesting a section that isn't set up, don't show
        if (!empty($this->section) && empty(config('tracking.venatus.' . $this->section))) {
            return false;
        }
        if (!AdCache::canHaveAds()) {
            // Using the adless middleware to define routes that have no ads (ie settings)
            return false;
        }
        // Parameter to force ads to be displayed
        if (request()->has('_showads')) {
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

        // Premium campaigns don't have ads displayed to their members
        return !empty($this->campaign) && !$this->campaign->boosted();
    }
}
