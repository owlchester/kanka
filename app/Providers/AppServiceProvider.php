<?php

namespace App\Providers;

use App\Facades\AdCache;
use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Facades\Img;
use App\Models\Ability;
use App\Models\Ad;
use App\Models\AppRelease;
use App\Models\CalendarWeather;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignFollower;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Models\CampaignStyle;
use App\Models\CampaignSubmission;
use App\Models\CampaignUser;
use App\Models\AttributeTemplate;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\CommunityEvent;
use App\Models\CommunityEventEntry;
use App\Models\CommunityVote;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityEvent;
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
use App\Models\QuestElement;
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
use App\Models\UserLog;
use App\Observers\CalendarObserver;
use App\Observers\CalendarWeatherObserver;
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
use App\Models\EntityLink;
use App\User;
use Carbon\Carbon;
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
        // Fix setups for utf8_mb4 mysql strings (emoji support)
        Schema::defaultStringLength(191);

        $this->registerWebObservers();

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
     * Register web observers (ie not running in console)
     * Kanka uses a lot of observers because they offer some magic, but
     * they also make a lot of stuff break.
     */
    protected function registerWebObservers()
    {
        // When in console (queue, commands), we don't want observers to trigger
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        // In production, we want URLs to be HTTPS for pagination and redirects
        if($this->app->environment('prod')) {
            \URL::forceScheme('https');
        }

        // Model observers. Lots of magic.
        Ability::observe('App\Observers\AbilityObserver');
        Ad::observe('App\Observers\AdObserver');
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
        CampaignDashboard::observe('App\Observers\CampaignDashboardObserver');
        CampaignSubmission::observe('App\Observers\CampaignSubmissionObserver');
        CampaignStyle::observe('App\Observers\CampaignStyleObserver');
        Character::observe(CharacterObserver::class);
        CharacterTrait::observe('App\Observers\CharacterTraitObserver');
        CommunityVote::observe('App\Observers\CommunityVoteObserver');
        CommunityEvent::observe('App\Observers\CommunityEventObserver');
        CommunityEventEntry::observe('App\Observers\CommunityEventEntryObserver');
        Conversation::observe('App\Observers\ConversationObserver');
        ConversationMessage::observe('App\Observers\ConversationMessageObserver');
        DiceRoll::observe('App\Observers\DiceRollObserver');
        DiceRollResult::observe('App\Observers\DiceRollResultObserver');
        Event::observe(EventObserver::class);
        Entity::observe('App\Observers\EntityObserver');
        EntityAbility::observe('App\Observers\EntityAbilityObserver');
        EntityFile::observe('App\Observers\EntityFileObserver');
        EntityLink::observe('App\Observers\EntityLinkObserver');
        EntityNote::observe('App\Observers\EntityNoteObserver');
        EntityEvent::observe('App\Observers\EntityEventObserver');
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
        UserLog::observe('App\Observers\UserLogObserver');
        Quest::observe('App\Observers\QuestObserver');
        QuestElement::observe('App\Observers\QuestElementObserver');

        Race::observe('App\Observers\RaceObserver');

        Relation::observe('App\Observers\RelationObserver');

        Release::observe('App\Observers\ReleaseObserver');

        // Tell laravel that we are using bootstrap 3 to style the paginators
        Paginator::useBootstrapThree();

        // Add our custom blade directives
        $this->addBladeDirectives();
    }


    /**
     * Setup some custom blade directives to simply some code
     * For example, use @admin in blade
     */
    protected function addBladeDirectives()
    {
        // Role based directives
        /*Blade::if('userRole', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });*/

        // Permission to view an entity
        Blade::if('viewentity', function (Entity $entity) {
            return EntityPermission::canView($entity);
        });

        // If a webp fallback is needed
        Blade::if('nowebp', function () {
            return Img::nowebp();
        });

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
        Blade::if('ads', function(string $section = null) {
            if (empty(config('tracking.adsense'))) {
                return false;
            }

            // If requesting a section but it isn't set up, don't show
            if (!empty($section) && empty(config('tracking.adsense_' . $section))) {
                return false;
            }

            // Always show ads to unlogged users
            if (!auth()->check()) {
                return true;
            }

            // Subscribed users don't have ads
            if (auth()->user()->isPatron()) {
                return false;
            }

            // User has been created less than 24 hours ago
            if (auth()->user()->created_at->diffInHours(Carbon::now()) < 24) {
                return false;
            }

            // Boosted campaigns don't either have ads displayed to their members
            $campaign = CampaignLocalization::getCampaign(false);
            return !empty($campaign) && !$campaign->boosted();
        });

        Blade::if('nativeAd', function (int $section) {
            // If we provided an ad test, override that
            if (request()->has('_adtest') && auth()->user()->hasRole('admin')) {
                return AdCache::test($section, request()->get('_adtest'));
            }
            if (!AdCache::has($section)) {
                return false;
            }
            // Always show ads to unlogged users
            if (!auth()->check()) {
                return true;
            }

            if (request()->get('_boost') === '0') {
                return true;
            }

            // Subscribed users don't have ads
            if (auth()->user()->isPatron()) {
                return false;
            }

            // User has been created less than 24 hours ago
            if (auth()->user()->created_at->diffInHours(Carbon::now()) < 24) {
                return false;
            }

            // Boosted campaigns don't either have ads displayed to their members
            $campaign = CampaignLocalization::getCampaign(false);
            return !empty($campaign) && !$campaign->boosted();
        });
    }
}
