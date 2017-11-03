<?php

namespace App\Providers;

use App\Campaign;
use App\Character;
use App\CharacterRelation;
use App\Family;
use App\FamilyRelation;
use App\Http\Validators\HashValidator;
use App\Item;
use App\Journal;
use App\Location;
use App\Note;
use App\Observers\CampaignObserver;
use App\Observers\CharacterObserver;
use App\Observers\CharacterRelationObserver;
use App\Observers\FamilyObserver;
use App\Observers\FamilyRelationObserver;
use App\Observers\ItemObserver;
use App\Observers\JournalObserver;
use App\Observers\LocationObserver;
use App\Observers\NoteObserver;
use App\Observers\OrganisationMemberObserver;
use App\Observers\OrganisationObserver;
use App\Observers\UserObserver;
use App\Organisation;
use App\OrganisationMember;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        FamilyRelation::observe(FamilyRelationObserver::class);
        Item::observe(ItemObserver::class);
        Journal::observe(JournalObserver::class);
        User::observe(UserObserver::class);
        Organisation::observe(OrganisationObserver::class);
        OrganisationMember::observe(OrganisationMemberObserver::class);
        Note::observe(NoteObserver::class);

        Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new HashValidator($translator, $data, $rules, $messages);
        });
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
