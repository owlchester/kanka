<?php

namespace App\Providers;

use App\Events\Campaigns\Applications\Accepted;
use App\Events\Campaigns\Applications\Rejected;
use App\Events\Campaigns\Deleted;
use App\Events\Campaigns\Exports\ExportCreated;
use App\Events\Campaigns\Followers\FollowerCreated;
use App\Events\Campaigns\Followers\FollowerRemoved;
use App\Events\Campaigns\Invites\InviteCreated;
use App\Events\Campaigns\Invites\InviteDeleted;
use App\Events\Campaigns\Members\RoleUserAdded;
use App\Events\Campaigns\Members\RoleUserRemoved;
use App\Events\Campaigns\Members\UserJoined;
use App\Events\Campaigns\Members\UserLeft;
use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginImported;
use App\Events\Campaigns\Plugins\PluginUpdated;
use App\Events\Campaigns\Roles\RoleCreated;
use App\Events\Campaigns\Roles\RoleDeleted;
use App\Events\Campaigns\Roles\RoleUpdated;
use App\Events\Campaigns\Saved;
use App\Events\Campaigns\Sidebar\SidebarReset;
use App\Events\Campaigns\Sidebar\SidebarSaved;
use App\Events\Campaigns\Styles\StyleCreated;
use App\Events\Campaigns\Styles\StyleDeleted;
use App\Events\Campaigns\Styles\StyleUpdated;
use App\Events\Campaigns\Thumbnails\ThumbnailCreated;
use App\Events\Campaigns\Thumbnails\ThumbnailDeleted;
use App\Events\Campaigns\Updated;
use App\Events\Campaigns\Webhooks\WebhookCreated;
use App\Events\Campaigns\Webhooks\WebhookDeleted;
use App\Events\Campaigns\Webhooks\WebhookTested;
use App\Events\Campaigns\Webhooks\WebhookUpdated;
use App\Events\FeatureCreated;
use App\Listeners\Campaigns\Admins\Notify;
use App\Listeners\Campaigns\Applications\LogApplication;
use App\Listeners\Campaigns\Campaigns\LogCampaign;
use App\Listeners\Campaigns\ClearCampaignCache;
use App\Listeners\Campaigns\ClearCampaignThemeCache;
use App\Listeners\Campaigns\ClearCampaignUsersSaved;
use App\Listeners\Campaigns\Exports\LogExport;
use App\Listeners\Campaigns\Followers\UpdateFollowerCount;
use App\Listeners\Campaigns\Invites\LogInvite;
use App\Listeners\Campaigns\Members\LogMember;
use App\Listeners\Campaigns\Members\LogUserRoleChanged;
use App\Listeners\Campaigns\Members\RunRoleUserJob;
use App\Listeners\Campaigns\Plugins\ClearThemeCache;
use App\Listeners\Campaigns\Plugins\LogPlugin;
use App\Listeners\Campaigns\Roles\LogRole;
use App\Listeners\Campaigns\Sidebar\LogSidebar;
use App\Listeners\Campaigns\Styles\LogStyle;
use App\Listeners\Campaigns\Thumbnails\LogThumbnail;
use App\Listeners\Campaigns\Webhooks\LogWebhook;
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
        ],
        StyleCreated::class => [
            LogStyle::class,
            ClearCampaignThemeCache::class,
        ],
        StyleUpdated::class => [
            LogStyle::class,
            ClearCampaignThemeCache::class,
        ],
        StyleDeleted::class => [
            LogStyle::class,
            ClearCampaignThemeCache::class,
        ],
        Accepted::class => [
            LogApplication::class,
            ClearCampaignCache::class,
            ClearUserCache::class,
        ],
        Rejected::class => [
            LogApplication::class,
            ClearCampaignCache::class,
        ],
        Saved::class => [
            ClearCampaignUsersSaved::class,
        ],
        Updated::class => [
            LogCampaign::class,
        ],
        Deleted::class => [
            ClearCampaignUsersSaved::class,
        ],
        WebhookCreated::class => [
            LogWebhook::class,
        ],
        WebhookUpdated::class => [
            LogWebhook::class,
        ],
        WebhookDeleted::class => [
            LogWebhook::class,
        ],
        WebhookTested::class => [
            LogWebhook::class,
        ],
        RoleCreated::class => [
            LogRole::class,
            ClearCampaignCache::class,
        ],
        RoleUpdated::class => [
            LogRole::class,
            ClearCampaignCache::class,
        ],
        RoleDeleted::class => [
            LogRole::class,
            ClearCampaignCache::class,
        ],
        ExportCreated::class => [
            LogExport::class,
        ],
        SidebarSaved::class => [
            LogSidebar::class,
        ],
        SidebarReset::class => [
            LogSidebar::class,
        ],
        ThumbnailCreated::class => [
            LogThumbnail::class,
            ClearCampaignCache::class,
        ],
        ThumbnailDeleted::class => [
            LogThumbnail::class,
            ClearCampaignCache::class,
        ],
        UserJoined::class => [
            Notify::class,
            ClearUserCache::class,
            LogMember::class,
        ],
        UserLeft::class => [
            Notify::class,
            ClearUserCache::class,
            LogMember::class,
        ],
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
