<?php

namespace App\Providers;

use App\Campaign;
use App\Character;
use App\CharacterRelation;
use App\Family;
use App\Location;
use App\Observers\CampaignObserver;
use App\Observers\CharacterObserver;
use App\Observers\CharacterRelationObserver;
use App\Observers\FamilyObserver;
use App\Observers\LocationObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Older mysql versions workaround
        Schema::defaultStringLength(191);

        // Observers
        Campaign::observe(CampaignObserver::class);
        Character::observe(CharacterObserver::class);
        CharacterRelation::observe(CharacterRelationObserver::class);
        Location::observe(LocationObserver::class);
        Family::observe(FamilyObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
