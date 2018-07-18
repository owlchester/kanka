<?php

namespace App\Providers;

use App\Campaign;
use App\CampaignUser;
use App\Models\AttributeTemplate;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\EntityNote;
use App\Models\Family;
use App\Http\Validators\HashValidator;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\CampaignInvite;
use App\Models\Event;
use App\Models\MapPoint;
use App\Models\MenuLink;
use App\Models\Quest;
use App\Models\QuestCharacter;
use App\Models\QuestLocation;
use App\Models\Note;
use App\Models\Relation;
use App\Models\Section;
use App\Observers\CalendarObserver;
use App\Observers\CampaignObserver;
use App\Observers\CampaignUserObserver;
use App\Observers\CharacterObserver;
use App\Observers\EventObserver;
use App\Observers\FamilyObserver;
use App\Observers\ItemObserver;
use App\Observers\JournalObserver;
use App\Observers\LocationObserver;
use App\Observers\NoteObserver;
use App\Observers\OrganisationMemberObserver;
use App\Observers\OrganisationObserver;
use App\Observers\UserObserver;
use App\Models\Organisation;
use App\Models\OrganisationMember;
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


        if (!app()->runningInConsole()) {
            // Observers
            AttributeTemplate::observe('App\Observers\AttributeTemplateObserver');
            Calendar::observe(CalendarObserver::class);
            Campaign::observe(CampaignObserver::class);
            CampaignUser::observe(CampaignUserObserver::class);
            CampaignInvite::observe('App\Observers\CampaignInviteObserver');
            //MapPoint::observe('App\Observers\MapPointObserver');
            Character::observe(CharacterObserver::class);
            DiceRoll::observe('App\Observers\DiceRollObserver');
            DiceRollResult::observe('App\Observers\DiceRollResultObserver');
            Event::observe(EventObserver::class);
            EntityNote::observe('App\Observers\EntityNoteObserver');
            Location::observe(LocationObserver::class);
            Family::observe(FamilyObserver::class);
            Item::observe(ItemObserver::class);
            MenuLink::observe('App\Observers\MenuLinkObserver');
            Journal::observe(JournalObserver::class);
            Organisation::observe(OrganisationObserver::class);
            OrganisationMember::observe(OrganisationMemberObserver::class);
            Section::observe('App\Observers\SectionObserver');
            Note::observe(NoteObserver::class);
            User::observe(UserObserver::class);
            Quest::observe('App\Observers\QuestObserver');
            QuestCharacter::observe('App\Observers\QuestCharacterObserver');
            QuestLocation::observe('App\Observers\QuestLocationObserver');

            Relation::observe('App\Observers\RelationObserver');
        }

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
