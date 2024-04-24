<?php

namespace App\Providers;

use App\Facades\AdCache;
use App\Facades\CampaignLocalization;
use App\User;
use Carbon\Carbon;
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
        $this
            ->addSubscribers();
    }


    /**
     * Condition to show actions or elements to users who is a subscriber
     */
    protected function addSubscribers(): self
    {
        Blade::if('subscriber', function () {
            if (auth()->guest()) {
                return true;
            }

            if (request()->get('_booster') === '0') {
                return false;
            }

            return auth()->user()->hasBoosters();
        });
        return $this;
    }
}
