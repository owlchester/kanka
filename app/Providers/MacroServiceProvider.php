<?php

namespace App\Providers;

use App\Facades\AdCache;
use App\Facades\CampaignLocalization;
use App\User;
use Carbon\Carbon;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class MacroServiceProvider
 *
 * This class contains the custom macros that we can use in blade views.
 *
 * @package App\Providers
 */
class MacroServiceProvider extends ServiceProvider
{
    /**
     * Define our macros
     */
    public function boot()
    {
        $this->addCustomBladeDirectives();
    }

    /**
     * Setup some custom blade directives to simply some code
     * For example, use @admin in blade
     */
    protected function addCustomBladeDirectives()
    {
        // Tutorial modal handler
        Blade::if('tutorial', function (string $tutorial) {
            // Not logged in? Don't bother
            if (!auth()->check()) {
                return false;
            }

            /** @var User $user */
            $user = auth()->user();

            // If disabled tutorials, remove all
            if ($user->disabledTutorial()) {
                return false;
            }

            return !$user->readTutorial($tutorial);
        });

        /** @ads() to show ads */
        Blade::if('ads', function (string $section = null) {
            if (empty(config('tracking.adsense'))) {
                return false;
            }

            // If requesting a section but it isn't set up, don't show
            if (!empty($section) && empty(config('tracking.adsense_' . $section))) {
                return false;
            }

            if (auth()->check()) {
                // Subscribed users don't have ads
                if (auth()->user()->isSubscriber()) {
                    return false;
                }
                // User has been created less than 24 hours ago
                if (auth()->user()->created_at->diffInHours(Carbon::now()) < 24) {
                    return false;
                }
            }

            // Boosted campaigns don't either have ads displayed to their members
            $campaign = CampaignLocalization::getCampaign(false);
            return !empty($campaign) && !$campaign->boosted();
        });

        Blade::if('nativeAd', function (int $section) {
            // If we provided an ad test, override that
            if (!config('app.admin')) {
                return false;
            }
            if (request()->has('_adtest') && auth()->user()->hasRole('admin')) {
                return AdCache::test($section, request()->get('_adtest'));
            }
            if (!AdCache::has($section)) {
                return false;
            }
            if (request()->get('_boost') === '0') {
                return true;
            }

            if (auth()->check()) {
                // Subscribed users don't have ads
                if (auth()->user()->isSubscriber()) {
                    return false;
                }
                // User has been created less than 24 hours ago
                if (auth()->user()->created_at->diffInHours(Carbon::now()) < 24) {
                    return false;
                }
            }

            // Boosted campaigns don't either have ads displayed to their members
            $campaign = CampaignLocalization::getCampaign(false);
            return !empty($campaign) && !$campaign->boosted();
        });

        /**
         * Condition to show actions or elements to users who is a subscriber
         */
        Blade::if('subscriber', function () {
            if (auth()->guest()) {
                return true;
            }

            if (request()->get('_booster') === '0') {
                return false;
            }

            return auth()->user()->hasBoosters();
        });
    }
}
