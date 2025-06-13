<?php

namespace App\Providers;

use App\Events\Campaigns\Followers\FollowerCreated;
use App\Events\Campaigns\Followers\FollowerRemoved;
use App\Events\Campaigns\Invites\InviteCreated;
use App\Events\Campaigns\Invites\InviteDeleted;
use App\Events\Campaigns\Members\RoleUserAdded;
use App\Events\Campaigns\Members\RoleUserRemoved;
use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginImported;
use App\Events\Campaigns\Plugins\PluginUpdated;
use App\Events\FeatureCreated;
use App\Listeners\Campaigns\ClearCampaignCache;
use App\Listeners\Campaigns\Followers\UpdateFollowerCount;
use App\Listeners\Campaigns\Invites\LogInvite;
use App\Listeners\Campaigns\Members\LogUserRoleChanged;
use App\Listeners\Campaigns\Members\RunRoleUserJob;
use App\Listeners\Campaigns\Plugins\ClearThemeCache;
use App\Listeners\Campaigns\Plugins\LogPlugin;
use App\Listeners\SendFeatureNotification;
use App\Listeners\Users\ClearUserCache;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use PragmaRX\Google2FALaravel\Listeners\LoginViaRemember;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        Login::class => [
            LoginViaRemember::class,
        ],
        FeatureCreated::class => [
            SendFeatureNotification::class,
        ],
        RoleUserAdded::class => [
            RunRoleUserJob::class,
            ClearUserCache::class,
            LogUserRoleChanged::class,
        ],
        RoleUserRemoved::class => [
            RunRoleUserJob::class,
            LogUserRoleChanged::class,
            ClearUserCache::class,
            ClearCampaignCache::class,
        ],
        FollowerCreated::class => [
            UpdateFollowerCount::class,
        ],
        FollowerRemoved::class => [
            UpdateFollowerCount::class,
        ],
        InviteCreated::class => [
            LogInvite::class,
        ],
        InviteDeleted::class => [
            LogInvite::class,
        ],
        PluginUpdated::class => [
            LogPlugin::class,
            ClearThemeCache::class,
        ],
        PluginDeleted::class => [
            LogPlugin::class,
            ClearThemeCache::class,
        ],
        PluginImported::class => [
            LogPlugin::class,
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UserEventSubscriber',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
