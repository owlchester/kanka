<?php

namespace App\Providers;

use App\Campaign;
use App\CampaignUser;
use App\Character;
use App\Models\CharacterAttribute;
use App\Models\CharacterRelation;
use App\Family;
use App\Models\FamilyRelation;
use App\Http\Validators\HashValidator;
use App\Item;
use App\Journal;
use App\Location;
use App\Models\CampaignInvite;
use App\Models\Event;
use App\Models\LocationRelation;
use App\Models\OrganisationRelation;
use App\Note;
use App\Observers\CampaignObserver;
use App\Observers\CampaignUserObserver;
use App\Observers\CampaignUserUserObserver;
use App\Observers\CharacterAttributeObserver;
use App\Observers\CharacterObserver;
use App\Observers\CharacterRelationObserver;
use App\Observers\EventObserver;
use App\Observers\FamilyObserver;
use App\Observers\FamilyRelationObserver;
use App\Observers\ItemObserver;
use App\Observers\JournalObserver;
use App\Observers\LocationObserver;
use App\Observers\LocationRelationObserver;
use App\Observers\NoteObserver;
use App\Observers\OrganisationMemberObserver;
use App\Observers\OrganisationObserver;
use App\Observers\OrganisationRelationObserver;
use App\Observers\UserObserver;
use App\Organisation;
use App\OrganisationMember;
use App\Policies\CampaignUserPolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
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
        CampaignUser::observe(CampaignUserObserver::class);
        CampaignInvite::observe('App\Observers\CampaignInviteObserver');
        Character::observe(CharacterObserver::class);
        CharacterRelation::observe(CharacterRelationObserver::class);
        CharacterAttribute::observe(CharacterAttributeObserver::class);
        Event::observe(EventObserver::class);
        Location::observe(LocationObserver::class);
        LocationRelation::observe(LocationRelationObserver::class);
        Family::observe(FamilyObserver::class);
        FamilyRelation::observe(FamilyRelationObserver::class);
        Item::observe(ItemObserver::class);
        Journal::observe(JournalObserver::class);
        Organisation::observe(OrganisationObserver::class);
        OrganisationMember::observe(OrganisationMemberObserver::class);
        OrganisationRelation::observe(OrganisationRelationObserver::class);
        Note::observe(NoteObserver::class);
        User::observe(UserObserver::class);

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
