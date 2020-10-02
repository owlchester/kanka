<?php

namespace App\Providers;

use App\Facades\EntityPermission;
use App\Facades\Img;
use App\Models\Ability;
use App\Models\AppRelease;
use App\Models\CalendarWeather;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignFollower;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Models\CampaignUser;
use App\Models\AttributeTemplate;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\CommunityEvent;
use App\Models\CommunityEventEntry;
use App\Models\CommunityVote;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityFile;
use App\Models\EntityNote;
use App\Models\Family;
use App\Http\Validators\HashValidator;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\CampaignInvite;
use App\Models\Event;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\MapPoint;
use App\Models\MenuLink;
use App\Models\Quest;
use App\Models\QuestCharacter;
use App\Models\QuestItem;
use App\Models\QuestLocation;
use App\Models\Note;
use App\Models\QuestOrganisation;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Release;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use App\Observers\CalendarObserver;
use App\Observers\CalendarWeatherObserver;
use App\Observers\CampaignObserver;
use App\Observers\CampaignUserObserver;
use App\Observers\CharacterObserver;
use App\Observers\CommunityEventObserver;
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
            if($this->app->environment('prod')) {
                \URL::forceScheme('https');
            }

            // Observers
            Ability::observe('App\Observers\AbilityObserver');
            AttributeTemplate::observe('App\Observers\AttributeTemplateObserver');
            AppRelease::observe('App\Observers\AppReleaseObserver');
            Calendar::observe(CalendarObserver::class);
            CalendarWeather::observe(CalendarWeatherObserver::class);
            Campaign::observe(CampaignObserver::class);
            CampaignUser::observe(CampaignUserObserver::class);
            CampaignRole::observe('App\Observers\CampaignRoleObserver');
            CampaignRoleUser::observe('App\Observers\CampaignRoleUserObserver');
            CampaignInvite::observe('App\Observers\CampaignInviteObserver');
            CampaignDashboardWidget::observe('App\Observers\CampaignDashboardWidgetObserver');
            CampaignFollower::observe('App\Observers\CampaignFollowerObserver');
            CampaignPlugin::observe('App\Observers\CampaignPluginObserver');
            CampaignSetting::observe('App\Observers\CampaignSettingObserver');
            //MapPoint::observe('App\Observers\MapPointObserver');
            Character::observe(CharacterObserver::class);
            CommunityVote::observe('App\Observers\CommunityVoteObserver');
            CommunityEvent::observe('App\Observers\CommunityEventObserver');
            CommunityEventEntry::observe('App\Observers\CommunityEventEntryObserver');
            Conversation::observe('App\Observers\ConversationObserver');
            ConversationMessage::observe('App\Observers\ConversationMessageObserver');
            DiceRoll::observe('App\Observers\DiceRollObserver');
            DiceRollResult::observe('App\Observers\DiceRollResultObserver');
            Event::observe(EventObserver::class);
            Entity::observe('App\Observers\EntityObserver');
            EntityNote::observe('App\Observers\EntityNoteObserver');
            EntityAbility::observe('App\Observers\EntityAbilityObserver');
            EntityFile::observe('App\Observers\EntityFileObserver');
            Location::observe(LocationObserver::class);
            Family::observe(FamilyObserver::class);
            Image::observe('App\Observers\ImageObserver');
            Item::observe(ItemObserver::class);
            Inventory::observe('App\Observers\InventoryObserver');
            Map::observe('App\Observers\MapObserver');
            MapPoint::observe('App\Observers\MapPointObserver');
            MapLayer::observe('App\Observers\MapLayerObserver');
            MapGroup::observe('App\Observers\MapGroupObserver');
            MapMarker::observe('App\Observers\MapMarkerObserver');
            MenuLink::observe('App\Observers\MenuLinkObserver');
            Journal::observe(JournalObserver::class);
            Organisation::observe(OrganisationObserver::class);
            OrganisationMember::observe(OrganisationMemberObserver::class);
            Tag::observe('App\Observers\TagObserver');
            Timeline::observe('App\Observers\TimelineObserver');
            TimelineEra::observe('App\Observers\TimelineEraObserver');
            TimelineElement::observe('App\Observers\TimelineElementObserver');
            Note::observe(NoteObserver::class);
            User::observe(UserObserver::class);
            Quest::observe('App\Observers\QuestObserver');
            QuestCharacter::observe('App\Observers\QuestCharacterObserver');
            QuestLocation::observe('App\Observers\QuestLocationObserver');
            QuestItem::observe('App\Observers\QuestItemObserver');
            QuestOrganisation::observe('App\Observers\QuestOrganisationObserver');
            Race::observe('App\Observers\RaceObserver');

            Relation::observe('App\Observers\RelationObserver');

            Release::observe('App\Observers\ReleaseObserver');

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
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });
        Blade::if('notEnv', function ($environment) {
            return !app()->environment($environment);
        });

        // API directive for users in the API role
        Blade::if('api', function () {
            return auth()->check() && auth()->user()->hasRole('api');
        });

        // Permission to view an entity
        Blade::if('viewentity', function (Entity $entity) {
            return EntityPermission::canView($entity);
        });

        // If a webp fallback is needed
        Blade::if('nowebp', function () {
            return Img::nowebp();
        });

//        Blade::if('campaigns', function () {
//            return auth()->check() && auth()->user()->hasCampaigns();
//        });
    }
}
