<?php

namespace App\Providers;

use App\Models\Ability;
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
use App\Models\CommunityEventEntry;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Creature;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\EntityEvent;
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
use App\Models\MenuLink;
use App\Models\Post;
use App\Models\Preset;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Note;
use App\Models\Race;
use App\Models\Relation;
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
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Cashier\Cashier;

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
        Cashier::useCustomerModel(User::class);

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
        if ($this->app->isProduction()) {
            \URL::forceScheme('https');
        }

        // Model observers. Lots of magic.
        Ability::observe('App\Observers\AbilityObserver');
        AttributeTemplate::observe('App\Observers\AttributeTemplateObserver');
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
        CommunityEventEntry::observe('App\Observers\CommunityEventEntryObserver');
        Conversation::observe('App\Observers\ConversationObserver');
        ConversationMessage::observe('App\Observers\ConversationMessageObserver');
        Creature::observe('App\Observers\CreatureObserver');
        DiceRoll::observe('App\Observers\DiceRollObserver');
        DiceRollResult::observe('App\Observers\DiceRollResultObserver');
        Event::observe(EventObserver::class);
        Entity::observe('App\Observers\EntityObserver');
        EntityAbility::observe('App\Observers\EntityAbilityObserver');
        EntityAsset::observe('App\Observers\EntityAssetObserver');
        Post::observe('App\Observers\PostObserver');
        EntityEvent::observe('App\Observers\EntityEventObserver');
        Location::observe(LocationObserver::class);
        Family::observe(FamilyObserver::class);
        Image::observe('App\Observers\ImageObserver');
        Item::observe(ItemObserver::class);
        Inventory::observe('App\Observers\InventoryObserver');
        Map::observe('App\Observers\MapObserver');
        MapLayer::observe('App\Observers\MapLayerObserver');
        MapGroup::observe('App\Observers\MapGroupObserver');
        MapMarker::observe('App\Observers\MapMarkerObserver');
        MenuLink::observe('App\Observers\MenuLinkObserver');
        Journal::observe(JournalObserver::class);
        Organisation::observe(OrganisationObserver::class);
        OrganisationMember::observe(OrganisationMemberObserver::class);
        Preset::observe('App\Observers\PresetObserver');
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

        // Tell laravel that we are using bootstrap 3 to style the paginators
        Paginator::useBootstrapThree();

        if (request()->has('_debug_perm')) {
            // Add in boot function
            DB::listen(function ($query) {
                $sql = $query->sql;
                foreach ($query->bindings as $key => $binding) {
                    $sql = preg_replace('/\?/', "'{$binding}'", $sql, 1);
                }
                dump($sql);
            });
        }
    }
}
