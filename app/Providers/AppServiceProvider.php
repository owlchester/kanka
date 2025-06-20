<?php

namespace App\Providers;

use App\Http\Validators\HashValidator;
use App\Models\Ability;
use App\Models\Application;
use App\Models\AttributeTemplate;
use App\Models\Bookmark;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignFollower;
use App\Models\CampaignInvite;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Models\CampaignStyle;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Creature;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\Event;
use App\Models\Family;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Post;
use App\Models\Preset;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Race;
use App\Models\Reminder;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use App\Models\User;
use App\Models\UserLog;
use App\Models\Webhook;
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
use App\Observers\TagObserver;
use App\Observers\UserObserver;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Passport\Passport;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Process\Process;

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

        Passport::$clientUuids = false;
        Passport::authorizationView('vendor.passport.authorize');

        $this->registerDevelopWarning();

        $this->registerWebObservers();
        Cashier::useCustomerModel(User::class);

        if (config('app.lazy')) {
            Model::preventLazyLoading();
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
    public function register() {}

    protected function registerDevelopWarning()
    {
        if (! app()->runningInConsole()) {
            return;
        }
        if (config('app.ignore_develop_warning')) {
            return;
        }

        $path = base_path();
        $command = 'git symbolic-ref -q --short HEAD || git describe --tags --exact-match';
        if (class_exists('\Symfony\Component\Process\Process')) {
            try {
                if (method_exists(Process::class, 'fromShellCommandline')) {
                    $process = Process::fromShellCommandline($command, $path);
                } else {
                    $process = new Process([$command], $path);
                }

                $process->mustRun();
                $output = $process->getOutput();
            } catch (Exception $e) {
                // Silence errors
            }
        }

        if (! empty($output) && Str::startsWith($output, 'develop')) {
            throw new InvalidOptionException(
                "CONFIGURATION WARNING\n" .
                "You are currently running Kanka on the unstable @develop branch. This is unstable and WILL RESULT IN DATA LOSS.\n" .
                "If this isn't a mistake, add `APP_IGNORE_DEVELOP_WARNING=true` to your .env file."
            );
        }
    }

    /**
     * Register web observers (ie not running in console)
     * Kanka uses a lot of observers because they offer some magic, but
     * they also make a lot of stuff break.
     */
    protected function registerWebObservers()
    {
        // When in console (queue, commands), we don't want observers to trigger.
        // We probably do, but we're so far down the rabbit hole that we no
        // longer want them.
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        // In production, we want URLs to be HTTPS for pagination and redirects
        if ($this->app->isProduction() || $this->app->environment('qa')) {
            \URL::forceScheme('https');
        }

        // Model observers. Lots of magic.
        Ability::observe('App\Observers\AbilityObserver');
        AttributeTemplate::observe('App\Observers\AttributeTemplateObserver');
        Calendar::observe(CalendarObserver::class);
        Campaign::observe(CampaignObserver::class);
        CampaignUser::observe(CampaignUserObserver::class);
        CampaignRole::observe('App\Observers\CampaignRoleObserver');
        CampaignRoleUser::observe('App\Observers\CampaignRoleUserObserver');
        CampaignInvite::observe('App\Observers\CampaignInviteObserver');
        CampaignDashboardWidget::observe('App\Observers\CampaignDashboardWidgetObserver');
        CampaignFollower::observe('App\Observers\CampaignFollowerObserver');
        CampaignPlugin::observe('App\Observers\CampaignPluginObserver');
        CampaignSetting::observe('App\Observers\CampaignSettingObserver');
        Application::observe('App\Observers\ApplicationObserver');
        CampaignStyle::observe('App\Observers\CampaignStyleObserver');
        Character::observe(CharacterObserver::class);
        Conversation::observe('App\Observers\ConversationObserver');
        ConversationMessage::observe('App\Observers\ConversationMessageObserver');
        Creature::observe('App\Observers\CreatureObserver');
        DiceRoll::observe('App\Observers\DiceRollObserver');
        DiceRollResult::observe('App\Observers\DiceRollResultObserver');
        Event::observe(EventObserver::class);
        Entity::observe('App\Observers\EntityObserver');
        EntityAbility::observe('App\Observers\EntityAbilityObserver');
        EntityAsset::observe('App\Observers\EntityAssetObserver');
        Location::observe(LocationObserver::class);
        Item::observe(ItemObserver::class);
        Journal::observe(JournalObserver::class);
        Note::observe(NoteObserver::class);
        Tag::observe(TagObserver::class);
        Post::observe('App\Observers\PostObserver');
        Reminder::observe('App\Observers\ReminderObserver');
        Family::observe(FamilyObserver::class);
        Image::observe('App\Observers\ImageObserver');
        Inventory::observe('App\Observers\InventoryObserver');
        Map::observe('App\Observers\MapObserver');
        MapLayer::observe('App\Observers\MapLayerObserver');
        MapGroup::observe('App\Observers\MapGroupObserver');
        MapMarker::observe('App\Observers\MapMarkerObserver');
        Bookmark::observe('App\Observers\BookmarkObserver');
        Organisation::observe(OrganisationObserver::class);
        OrganisationMember::observe(OrganisationMemberObserver::class);
        Preset::observe('App\Observers\PresetObserver');
        Timeline::observe('App\Observers\TimelineObserver');
        TimelineEra::observe('App\Observers\TimelineEraObserver');
        TimelineElement::observe('App\Observers\TimelineElementObserver');
        User::observe(UserObserver::class);
        UserLog::observe('App\Observers\UserLogObserver');
        Webhook::observe('App\Observers\WebhookObserver');
        Quest::observe('App\Observers\QuestObserver');
        QuestElement::observe('App\Observers\QuestElementObserver');
        Race::observe('App\Observers\RaceObserver');

        if (request()->has('_debug_perm') && config('app.debug')) {
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
