<?php

namespace App\Providers;

use App\Facades\EntityPermission;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\AttributeTemplate;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\Entity;
use App\Models\EntityFile;
use App\Models\EntityNote;
use App\Models\Family;
use App\Http\Validators\HashValidator;
use App\Models\Inventory;
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
use App\Models\Race;
use App\Models\Relation;
use App\Models\Tag;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
            CampaignRoleUser::observe('App\Observers\CampaignRoleUserObserver');
            CampaignInvite::observe('App\Observers\CampaignInviteObserver');
            CampaignDashboardWidget::observe('App\Observers\CampaignDashboardWidgetObserver');
            //MapPoint::observe('App\Observers\MapPointObserver');
            Character::observe(CharacterObserver::class);
            Conversation::observe('App\Observers\ConversationObserver');
            ConversationMessage::observe('App\Observers\ConversationMessageObserver');
            DiceRoll::observe('App\Observers\DiceRollObserver');
            DiceRollResult::observe('App\Observers\DiceRollResultObserver');
            Event::observe(EventObserver::class);
            Entity::observe('App\Observers\EntityObserver');
            EntityNote::observe('App\Observers\EntityNoteObserver');
            EntityFile::observe('App\Observers\EntityFileObserver');
            Location::observe(LocationObserver::class);
            Family::observe(FamilyObserver::class);
            Item::observe(ItemObserver::class);
            Inventory::observe('App\Observers\InventoryObserver');
            MapPoint::observe('App\Observers\MapPointObserver');
            MenuLink::observe('App\Observers\MenuLinkObserver');
            Journal::observe(JournalObserver::class);
            Organisation::observe(OrganisationObserver::class);
            OrganisationMember::observe(OrganisationMemberObserver::class);
            Tag::observe('App\Observers\TagObserver');
            Note::observe(NoteObserver::class);
            User::observe(UserObserver::class);
            Quest::observe('App\Observers\QuestObserver');
            QuestCharacter::observe('App\Observers\QuestCharacterObserver');
            QuestLocation::observe('App\Observers\QuestLocationObserver');
            Race::observe('App\Observers\RaceObserver');

            Relation::observe('App\Observers\RelationObserver');

            Paginator::useBootstrapThree();

            $this->addBladeDirectives();
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

    /**
     *
     */
    protected function addBladeDirectives()
    {
        // Role based directives
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->hasRole('admin');
        });
        Blade::if('translator', function () {
            return auth()->check() && auth()->user()->hasRole('translator');
        });
        Blade::if('moderator', function () {
            return auth()->check() && auth()->user()->hasRole('moderator');
        });

        // API directive for users in the API role
        Blade::if('api', function () {
            return auth()->check() && auth()->user()->hasRole('api');
        });

        // Permission to view an entity
        Blade::if('viewentity', function (Entity $entity) {
            return EntityPermission::canView($entity);
        });

//        Blade::if('campaigns', function () {
//            return auth()->check() && auth()->user()->hasCampaigns();
//        });
    }
}
