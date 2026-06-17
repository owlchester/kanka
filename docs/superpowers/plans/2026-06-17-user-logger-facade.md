# UserLogger Facade Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Extract `User::log()` and `User::campaignLog()` into a `UserLogger` facade backed by `UserLoggerService`, removing logging responsibility from the `User` model.

**Architecture:** New `UserLoggerService` (in `app/Services/Logs/`) uses the existing `UserAware` trait for fluent chaining. A `UserLogger` facade and `UserLoggerServiceProvider` follow the same pattern as the existing `ApiLog` facade. All ~48 call sites across listeners, services, jobs, observers, middleware, and controllers are updated to use `UserLogger::user($user)->log()` / `UserLogger::user($user)->campaign()`.

**Tech Stack:** Laravel 11, PHP 8.4, existing `UserAware` trait, existing `Identity` facade, existing `UserLog` model, existing `UserAction` enum.

---

### Task 1: Write failing tests for UserLoggerService

**Files:**
- Create: `tests/Feature/Services/Logs/UserLoggerServiceTest.php`

- [ ] **Step 1: Create the test file**

```bash
vendor/bin/sail artisan make:test --pest Services/Logs/UserLoggerServiceTest
```

- [ ] **Step 2: Replace contents with these tests**

```php
<?php

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Models\User;
use App\Services\Logs\UserLoggerService;

it('resolves UserLoggerService via facade', function () {
    $user = User::factory()->create();
    $service = UserLogger::user($user);

    expect($service)->toBeInstanceOf(UserLoggerService::class)
        ->and($service->user)->toBe($user);
});

it('does nothing when logging is disabled', function () {
    config(['logging.enabled' => false]);
    $user = User::factory()->create();

    // Neither method should throw or attempt DB writes
    UserLogger::user($user)->log(UserAction::login);
    UserLogger::user($user)->campaign(1, 'members', 'joined');

    expect(true)->toBeTrue();
});

it('user() returns the service for chaining', function () {
    $user = User::factory()->create();
    $service = app(UserLoggerService::class);

    expect($service->user($user))->toBe($service);
});
```

- [ ] **Step 3: Run the tests — expect failure (class not found)**

```bash
vendor/bin/sail artisan test --compact --filter=UserLoggerServiceTest
```

Expected: FAIL — `App\Facades\UserLogger` not found.

---

### Task 2: Create UserLoggerService, UserLogger facade, and provider

**Files:**
- Create: `app/Services/Logs/UserLoggerService.php`
- Create: `app/Facades/UserLogger.php`
- Create: `app/Providers/Logs/UserLoggerServiceProvider.php`
- Modify: `config/app.php`

- [ ] **Step 1: Create `app/Services/Logs/UserLoggerService.php`**

```php
<?php

namespace App\Services\Logs;

use App\Enums\UserAction;
use App\Facades\Identity;
use App\Models\UserLog;
use App\Traits\UserAware;

class UserLoggerService
{
    use UserAware;

    public function log(UserAction $action, array $data = []): void
    {
        if (! config('logging.enabled')) {
            return;
        }
        $log = new UserLog(['user_id' => $this->user->id]);
        $log->type_id = $action;
        $log->data = ! empty($data) ? $data : null;
        $log->save();
    }

    public function campaign(int $campaignId, string $module, string $action, array $data = []): void
    {
        if (! config('logging.enabled')) {
            return;
        }
        $log = new UserLog(['user_id' => $this->user->id]);
        $log->type_id = UserAction::campaign;
        $log->campaign_id = $campaignId;
        $log->data = array_merge(['module' => $module, 'action' => $action], $data);
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->save();
    }
}
```

- [ ] **Step 2: Create `app/Facades/UserLogger.php`**

```php
<?php

namespace App\Facades;

use App\Services\Logs\UserLoggerService;
use Illuminate\Support\Facades\Facade;

/**
 * @see UserLoggerService
 *
 * @mixin UserLoggerService
 */
class UserLogger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'user_logger';
    }
}
```

- [ ] **Step 3: Create `app/Providers/Logs/UserLoggerServiceProvider.php`**

```php
<?php

namespace App\Providers\Logs;

use App\Services\Logs\UserLoggerService;
use Illuminate\Support\ServiceProvider;

class UserLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserLoggerService::class, fn () => new UserLoggerService);
        $this->app->alias(UserLoggerService::class, 'user_logger');
    }
}
```

- [ ] **Step 4: Register the provider in `config/app.php`**

Add the import at the top with the other `Logs` provider:

```php
// Around line 35, after:
use App\Providers\Logs\ApiLogServiceProvider;
// Add:
use App\Providers\Logs\UserLoggerServiceProvider;
```

Add to the `providers` array near `ApiLogServiceProvider::class` (around line 349):

```php
ApiLogServiceProvider::class,
UserLoggerServiceProvider::class,
```

- [ ] **Step 5: Run the tests — expect pass**

```bash
vendor/bin/sail artisan test --compact --filter=UserLoggerServiceTest
```

Expected: PASS (3 tests).

- [ ] **Step 6: Commit**

```bash
git add app/Services/Logs/UserLoggerService.php app/Facades/UserLogger.php app/Providers/Logs/UserLoggerServiceProvider.php config/app.php tests/Feature/Services/Logs/UserLoggerServiceTest.php
git commit -m "feat: add UserLogger facade backed by UserLoggerService"
```

---

### Task 3: Update Campaign listeners (batch 1)

**Files — Modify:**
- `app/Listeners/Campaigns/Campaigns/LogCampaign.php`
- `app/Listeners/Campaigns/Roles/LogRole.php`
- `app/Listeners/Campaigns/Sidebar/LogSidebar.php`
- `app/Listeners/Campaigns/Plugins/LogPlugin.php`
- `app/Listeners/Campaigns/Styles/LogStyle.php`
- `app/Listeners/Campaigns/Exports/LogExport.php`
- `app/Listeners/Campaigns/Dashboards/LogDashboard.php`
- `app/Listeners/Campaigns/Members/LogMember.php`

- [ ] **Step 1: Update `app/Listeners/Campaigns/Campaigns/LogCampaign.php`**

Add import, replace both `campaignLog` calls:

```php
<?php

namespace App\Listeners\Campaigns\Campaigns;

use App\Events\Campaigns\Updated;
use App\Facades\UserLogger;

class LogCampaign
{
    public function handle(Updated $event): void
    {
        if ($event->campaign->wasChanged('is_open')) {
            UserLogger::user($event->user)->campaign(
                $event->campaign->id,
                'applications',
                'switch',
                ['new' => $event->campaign->isOpen() ? 'open' : 'closed']
            );
        }
        if ($event->campaign->wasChanged('visibility_id')) {
            UserLogger::user($event->user)->campaign(
                $event->campaign->id,
                'visibility',
                'switch',
                ['new' => $event->campaign->isPublic() ? 'public' : 'private']
            );
        }
    }
}
```

- [ ] **Step 2: Update `app/Listeners/Campaigns/Roles/LogRole.php`**

```php
<?php

namespace App\Listeners\Campaigns\Roles;

use App\Events\Campaigns\Roles\RoleCreated;
use App\Events\Campaigns\Roles\RoleDeleted;
use App\Events\Campaigns\Roles\RoleUpdated;
use App\Facades\UserLogger;

class LogRole
{
    public function handle(RoleCreated|RoleUpdated|RoleDeleted $event): void
    {
        $action = match (true) {
            $event instanceof RoleCreated => 'created',
            $event instanceof RoleUpdated => 'updated',
            $event instanceof RoleDeleted => 'deleted',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaignRole->campaign_id,
            'roles',
            $action,
            [
                'name' => $event->campaignRole->name,
                'id' => $event->campaignRole->id,
            ]
        );
    }
}
```

- [ ] **Step 3: Update `app/Listeners/Campaigns/Sidebar/LogSidebar.php`**

```php
<?php

namespace App\Listeners\Campaigns\Sidebar;

use App\Events\Campaigns\Sidebar\SidebarReset;
use App\Events\Campaigns\Sidebar\SidebarSaved;
use App\Facades\UserLogger;

class LogSidebar
{
    public function handle(SidebarReset|SidebarSaved $event): void
    {
        if (! $event->campaign->wasChanged('ui_settings')) {
            return;
        }
        $action = match (true) {
            $event instanceof SidebarReset => 'reset',
            $event instanceof SidebarSaved => 'updated',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'sidebar',
            $action,
        );
    }
}
```

- [ ] **Step 4: Update `app/Listeners/Campaigns/Plugins/LogPlugin.php`**

```php
<?php

namespace App\Listeners\Campaigns\Plugins;

use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginImported;
use App\Events\Campaigns\Plugins\PluginUpdated;
use App\Facades\UserLogger;

class LogPlugin
{
    public function handle(PluginUpdated|PluginDeleted|PluginImported $event): void
    {
        $action = $event instanceof PluginUpdated ? 'updated' : 'deleted';
        if ($event instanceof PluginUpdated) {
            $action = 'updated';
            if ($event->campaignPlugin->wasChanged('is_active')) {
                $action = $event->campaignPlugin->is_active ? 'enabled' : 'disabled';
            }
            if ($event->campaignPlugin->wasChanged('plugin_version_id')) {
                $action = 'updated';
            }
        }
        if ($event instanceof PluginImported) {
            $action = 'imported';
        }

        UserLogger::user($event->user)->campaign(
            $event->campaignPlugin->campaign_id,
            'plugins',
            $action,
            [
                'name' => $event->campaignPlugin->plugin->name,
                'id' => $event->campaignPlugin->id,
                'plugin' => $event->campaignPlugin->plugin_id,
            ]
        );
    }
}
```

- [ ] **Step 5: Update `app/Listeners/Campaigns/Styles/LogStyle.php`**

```php
<?php

namespace App\Listeners\Campaigns\Styles;

use App\Events\Campaigns\Styles\StyleCreated;
use App\Events\Campaigns\Styles\StyleDeleted;
use App\Events\Campaigns\Styles\StyleUpdated;
use App\Facades\UserLogger;

class LogStyle
{
    public function handle(StyleCreated|StyleUpdated|StyleDeleted $event): void
    {
        $action = match (true) {
            $event instanceof StyleCreated => 'created',
            $event instanceof StyleUpdated => 'updated',
            $event instanceof StyleDeleted => 'deleted',
        };
        if ($event instanceof StyleUpdated && $event->campaignStyle->wasChanged('is_enabled')) {
            $action = $event->campaignStyle->is_enabled ? 'enabled' : 'disabled';
        }

        UserLogger::user($event->user)->campaign(
            $event->campaignStyle->campaign_id,
            'styles',
            $action,
            [
                'name' => $event->campaignStyle->name,
                'id' => $event->campaignStyle->id,
            ]
        );
    }
}
```

- [ ] **Step 6: Update `app/Listeners/Campaigns/Exports/LogExport.php`**

```php
<?php

namespace App\Listeners\Campaigns\Exports;

use App\Events\Campaigns\Exports\ExportCreated;
use App\Facades\UserLogger;

class LogExport
{
    public function handle(ExportCreated $event): void
    {
        UserLogger::user($event->user)->campaign(
            $event->campaignExport->campaign_id,
            'export',
            'queued'
        );
    }
}
```

- [ ] **Step 7: Update `app/Listeners/Campaigns/Dashboards/LogDashboard.php`**

```php
<?php

namespace App\Listeners\Campaigns\Dashboards;

use App\Events\Campaigns\Dashboards\DashboardCreated;
use App\Events\Campaigns\Dashboards\DashboardDeleted;
use App\Events\Campaigns\Dashboards\DashboardUpdated;
use App\Facades\UserLogger;

class LogDashboard
{
    public function handle(DashboardCreated|DashboardUpdated|DashboardDeleted $event): void
    {
        $action = match (true) {
            $event instanceof DashboardCreated => 'created',
            $event instanceof DashboardUpdated => 'updated',
            $event instanceof DashboardDeleted => 'deleted',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaignDashboard->campaign_id,
            'dashboards',
            $action,
            [
                'name' => $event->campaignDashboard->name,
                'id' => $event->campaignDashboard->id,
            ]
        );
    }
}
```

- [ ] **Step 8: Update `app/Listeners/Campaigns/Members/LogMember.php`**

```php
<?php

namespace App\Listeners\Campaigns\Members;

use App\Events\Campaigns\Members\Switched;
use App\Events\Campaigns\Members\UserJoined;
use App\Events\Campaigns\Members\UserLeft;
use App\Facades\UserLogger;

class LogMember
{
    public function handle(UserJoined|UserLeft|Switched $event): void
    {
        $action = 'joined';
        $params = [];
        if ($event instanceof UserLeft) {
            $action = 'left';
        } elseif ($event instanceof Switched) {
            $action = 'switched';
            $params = ['to' => $event->campaignUser->user->name];
        } elseif ($event instanceof UserJoined) {
            $params = ['invite' => $event->campaignInvite->id];
        }

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'members',
            $action,
            $params,
        );
    }
}
```

- [ ] **Step 9: Run tests to confirm no regressions**

```bash
vendor/bin/sail artisan test --compact
```

Expected: PASS.

- [ ] **Step 10: Commit**

```bash
git add app/Listeners/Campaigns/Campaigns/LogCampaign.php \
        app/Listeners/Campaigns/Roles/LogRole.php \
        app/Listeners/Campaigns/Sidebar/LogSidebar.php \
        app/Listeners/Campaigns/Plugins/LogPlugin.php \
        app/Listeners/Campaigns/Styles/LogStyle.php \
        app/Listeners/Campaigns/Exports/LogExport.php \
        app/Listeners/Campaigns/Dashboards/LogDashboard.php \
        app/Listeners/Campaigns/Members/LogMember.php
git commit -m "refactor: use UserLogger facade in campaign listeners (batch 1)"
```

---

### Task 4: Update Campaign listeners (batch 2)

**Files — Modify:**
- `app/Listeners/Campaigns/Members/LogUserRoleChanged.php`
- `app/Listeners/Campaigns/Applications/LogApplication.php`
- `app/Listeners/Campaigns/Invites/LogInvite.php`
- `app/Listeners/Campaigns/Thumbnails/LogThumbnail.php`
- `app/Listeners/Campaigns/Thumbnails/LogThumbnails.php`
- `app/Listeners/Campaigns/Webhooks/LogWebhook.php`
- `app/Listeners/Campaigns/EntityTypes/LogEntityType.php`

- [ ] **Step 1: Update `app/Listeners/Campaigns/Members/LogUserRoleChanged.php`**

```php
<?php

namespace App\Listeners\Campaigns\Members;

use App\Events\Campaigns\Members\RoleUserAdded;
use App\Events\Campaigns\Members\RoleUserRemoved;
use App\Facades\UserLogger;

class LogUserRoleChanged
{
    public function handle(RoleUserAdded|RoleUserRemoved $event): void
    {
        $action = $event instanceof RoleUserAdded ? 'created' : 'deleted';

        if (! isset($event->campaignRoleUser->campaignRole)) {
            return;
        }

        UserLogger::user($event->user)->campaign(
            $event->campaignRoleUser->campaignRole->campaign_id,
            'user-role',
            $action,
            [
                'user' => $event->campaignRoleUser->user->name,
                'user_id' => $event->campaignRoleUser->user_id,
                'role' => $event->campaignRoleUser->campaignRole->name,
                'role_id' => $event->campaignRoleUser->campaign_role_id,
            ]
        );
    }
}
```

- [ ] **Step 2: Update `app/Listeners/Campaigns/Applications/LogApplication.php`**

```php
<?php

namespace App\Listeners\Campaigns\Applications;

use App\Events\Campaigns\Applications\Accepted;
use App\Events\Campaigns\Applications\Rejected;
use App\Facades\UserLogger;

class LogApplication
{
    public function handle(Accepted|Rejected $event): void
    {
        $action = $event instanceof Accepted ? 'accepted' : 'rejected';

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'applications',
            $action,
            [
                'user' => $event->application->user->name,
                'id' => $event->application->user_id,
            ]
        );
    }
}
```

- [ ] **Step 3: Update `app/Listeners/Campaigns/Invites/LogInvite.php`**

```php
<?php

namespace App\Listeners\Campaigns\Invites;

use App\Events\Campaigns\Invites\InviteCreated;
use App\Events\Campaigns\Invites\InviteDeleted;
use App\Facades\UserLogger;

class LogInvite
{
    public function handle(InviteCreated|InviteDeleted $event): void
    {
        $action = $event instanceof InviteCreated ? 'created' : 'deleted';

        UserLogger::user($event->user)->campaign(
            $event->campaignInvite->campaign_id,
            'invites',
            $action,
            [
                'id' => $event->campaignInvite->id,
            ]
        );
    }
}
```

- [ ] **Step 4: Update `app/Listeners/Campaigns/Thumbnails/LogThumbnail.php`**

```php
<?php

namespace App\Listeners\Campaigns\Thumbnails;

use App\Events\Campaigns\Thumbnails\ThumbnailCreated;
use App\Events\Campaigns\Thumbnails\ThumbnailDeleted;
use App\Facades\UserLogger;

class LogThumbnail
{
    public function handle(ThumbnailCreated|ThumbnailDeleted $event): void
    {
        $action = match (true) {
            $event instanceof ThumbnailCreated => 'created',
            $event instanceof ThumbnailDeleted => 'deleted',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'thumbnails',
            $action,
            [
                'type' => $event->entityType->code,
            ]
        );
    }
}
```

- [ ] **Step 5: Update `app/Listeners/Campaigns/Thumbnails/LogThumbnails.php`**

```php
<?php

namespace App\Listeners\Campaigns\Thumbnails;

use App\Events\Campaigns\Thumbnails\ThumbnailsDeleted;
use App\Facades\UserLogger;

class LogThumbnails
{
    public function handle(ThumbnailsDeleted $event): void
    {
        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'thumbnails',
            'deleted',
        );
    }
}
```

- [ ] **Step 6: Update `app/Listeners/Campaigns/Webhooks/LogWebhook.php`**

```php
<?php

namespace App\Listeners\Campaigns\Webhooks;

use App\Events\Campaigns\Webhooks\WebhookCreated;
use App\Events\Campaigns\Webhooks\WebhookDeleted;
use App\Events\Campaigns\Webhooks\WebhookTested;
use App\Events\Campaigns\Webhooks\WebhookUpdated;
use App\Facades\UserLogger;

class LogWebhook
{
    public function handle(WebhookCreated|WebhookUpdated|WebhookDeleted|WebhookTested $event): void
    {
        $action = match (true) {
            $event instanceof WebhookCreated => 'created',
            $event instanceof WebhookUpdated => 'updated',
            $event instanceof WebhookDeleted => 'deleted',
            $event instanceof WebhookTested => 'tested',
        };

        if ($event instanceof WebhookUpdated && $event->webhook->wasChanged('status')) {
            $action = $event->webhook->status ? 'enabled' : 'disabled';
        }

        UserLogger::user($event->user)->campaign(
            $event->webhook->campaign_id,
            'webhooks',
            $action,
            [
                'id' => $event->webhook->id,
            ]
        );
    }
}
```

- [ ] **Step 7: Update `app/Listeners/Campaigns/EntityTypes/LogEntityType.php`**

```php
<?php

namespace App\Listeners\Campaigns\EntityTypes;

use App\Events\Campaigns\EntityTypes\EntityTypeCreated;
use App\Events\Campaigns\EntityTypes\EntityTypeDeleted;
use App\Events\Campaigns\EntityTypes\EntityTypeToggled;
use App\Events\Campaigns\EntityTypes\EntityTypeUpdated;
use App\Facades\UserLogger;

class LogEntityType
{
    public function handle(EntityTypeCreated|EntityTypeUpdated|EntityTypeDeleted|EntityTypeToggled $event): void
    {
        if (! isset($event->entityType->campaign_id) && ! isset($event->campaign)) {
            return;
        }

        $action = match (true) {
            $event instanceof EntityTypeCreated => 'created',
            $event instanceof EntityTypeUpdated => 'updated',
            $event instanceof EntityTypeDeleted => 'deleted',
            $event instanceof EntityTypeToggled => 'toggled',
        };

        if ($event instanceof EntityTypeUpdated && $event->entityType->wasChanged('is_enabled')) {
            $action = $event->entityType->is_enabled ? 'enabled' : 'disabled';
        } elseif ($event instanceof EntityTypeToggled) {
            $action = $event->campaign->setting->{$event->entityType->pluralCode()} ? 'enabled' : 'disabled';
        }

        UserLogger::user($event->user)->campaign(
            $event->entityType->campaign_id ?? $event->campaign->id,
            'modules',
            $action,
            [
                'id' => $event->entityType->id,
                'code' => $event->entityType->code,
            ]
        );
    }
}
```

- [ ] **Step 8: Run tests to confirm no regressions**

```bash
vendor/bin/sail artisan test --compact
```

Expected: PASS.

- [ ] **Step 9: Commit**

```bash
git add app/Listeners/Campaigns/Members/LogUserRoleChanged.php \
        app/Listeners/Campaigns/Applications/LogApplication.php \
        app/Listeners/Campaigns/Invites/LogInvite.php \
        app/Listeners/Campaigns/Thumbnails/LogThumbnail.php \
        app/Listeners/Campaigns/Thumbnails/LogThumbnails.php \
        app/Listeners/Campaigns/Webhooks/LogWebhook.php \
        app/Listeners/Campaigns/EntityTypes/LogEntityType.php
git commit -m "refactor: use UserLogger facade in campaign listeners (batch 2)"
```

---

### Task 5: Update remaining listeners

**Files — Modify:**
- `app/Listeners/Users/Subscriptions/LogPremium.php`
- `app/Listeners/Entities/LogEntity.php`
- `app/Listeners/Posts/LogPost.php`
- `app/Listeners/UserEventSubscriber.php`

- [ ] **Step 1: Update `app/Listeners/Users/Subscriptions/LogPremium.php`**

```php
<?php

namespace App\Listeners\Users\Subscriptions;

use App\Events\Subscriptions\AutoRemove;
use App\Events\Subscriptions\Boost;
use App\Events\Subscriptions\Disable;
use App\Events\Subscriptions\Premium;
use App\Events\Subscriptions\SuperBoost;
use App\Events\Subscriptions\Upgrade;
use App\Facades\UserLogger;

class LogPremium
{
    public function handle(Boost|SuperBoost|Upgrade|Premium|AutoRemove|Disable $event): void
    {
        $action = match (true) {
            $event instanceof Boost => 'boosted',
            $event instanceof SuperBoost => 'superboosted',
            $event instanceof Upgrade => 'upgraded',
            $event instanceof Premium => 'premium',
            $event instanceof AutoRemove => 'auto-removed',
            $event instanceof Disable => 'disabled',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'premium',
            $action
        );
    }
}
```

- [ ] **Step 2: Update `app/Listeners/Entities/LogEntity.php`**

`$event->user` may be null here, so add an explicit null guard:

```php
<?php

namespace App\Listeners\Entities;

use App\Events\Entities\EntityRestored;
use App\Facades\UserLogger;

class LogEntity
{
    public function handle(EntityRestored $event): void
    {
        if (! $event->user) {
            return;
        }

        UserLogger::user($event->user)->campaign(
            $event->entity->campaign_id,
            'recovery',
            'entity',
            [
                'type' => $event->entity->entityType->code,
                'name' => $event->entity->name,
                'id' => $event->entity->id,
            ]
        );
    }
}
```

- [ ] **Step 3: Update `app/Listeners/Posts/LogPost.php`**

Replace `$event->user->log(UserAction::post, [...])` with the facade. Find the `$event->user->log(` call (around line 69) and replace:

```php
// Remove this import if it becomes unused after the change:
// use App\Enums\UserAction;
// Keep it - UserAction is still used for $actionId assignments above

UserLogger::user($event->user)->log(
    UserAction::post,
    [
        'action' => $action,
        'id' => $event->post->id,
    ]
);
```

Also add the import at the top:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 4: Update `app/Listeners/UserEventSubscriber.php`**

Find the `$event->user->log(UserAction::logout)` call (around line 81) and replace:

```php
UserLogger::user($event->user)->log(UserAction::logout);
```

Also add the import at the top of the file:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 5: Run tests**

```bash
vendor/bin/sail artisan test --compact
```

Expected: PASS.

- [ ] **Step 6: Commit**

```bash
git add app/Listeners/Users/Subscriptions/LogPremium.php \
        app/Listeners/Entities/LogEntity.php \
        app/Listeners/Posts/LogPost.php \
        app/Listeners/UserEventSubscriber.php
git commit -m "refactor: use UserLogger facade in remaining listeners"
```

---

### Task 6: Update services

**Files — Modify:**
- `app/Services/Campaign/ModuleEditService.php`
- `app/Services/Onboarding/InitialService.php`
- `app/Services/SubscriptionService.php`
- `app/Services/PayPalService.php`
- `app/Services/Auth/LoginService.php`

- [ ] **Step 1: Update `app/Services/Campaign/ModuleEditService.php`**

Find `$this->user->campaignLog($this->campaign->id, 'modules', 'reset')` (around line 100) and replace:

```php
UserLogger::user($this->user)->campaign($this->campaign->id, 'modules', 'reset');
```

Add import at the top:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 2: Update `app/Services/Onboarding/InitialService.php`**

The `log()` helper method calls `$this->user->campaignLog(...)` in two places. Replace the entire `log()` method body and the inline `campaignLog` in `saveName()`:

In the `protected function log(string $type): void` method, replace `$this->user->campaignLog(...)` with:

```php
UserLogger::user($this->user)->campaign(
    $this->campaign->id,
    'onboarding',
    $type,
);
```

In `saveName()`, replace `$this->user->campaignLog(...)` with:

```php
UserLogger::user($this->user)->campaign(
    $this->campaign->id,
    'onboarding',
    'rename'
);
```

Add import at the top:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 3: Update `app/Services/SubscriptionService.php`**

Find all `$this->user->log(UserAction::...)` calls (lines ~175, ~183, ~186, ~216) and replace each with:

```php
UserLogger::user($this->user)->log(UserAction::subNew);    // line ~175
UserLogger::user($this->user)->log(UserAction::subDowngrade); // line ~183
UserLogger::user($this->user)->log(UserAction::subUpgrade);   // line ~186
UserLogger::user($this->user)->log(UserAction::subDowngrade); // line ~216
```

Add import at the top:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 4: Update `app/Services/PayPalService.php`**

Find `$this->user->log(UserAction::subPaypal)` (around line 104) and replace:

```php
UserLogger::user($this->user)->log(UserAction::subPaypal);
```

Add import at the top:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 5: Update `app/Services/Auth/LoginService.php`**

Find `$this->user->log($userLogType)` (around line 24) and replace:

```php
UserLogger::user($this->user)->log($userLogType);
```

Add import at the top:

```php
use App\Facades\UserLogger;
```

- [ ] **Step 6: Run tests**

```bash
vendor/bin/sail artisan test --compact
```

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add app/Services/Campaign/ModuleEditService.php \
        app/Services/Onboarding/InitialService.php \
        app/Services/SubscriptionService.php \
        app/Services/PayPalService.php \
        app/Services/Auth/LoginService.php
git commit -m "refactor: use UserLogger facade in services"
```

---

### Task 7: Update jobs, observers, middleware, and controller

**Files — Modify:**
- `app/Jobs/Emails/SubscriptionFailedEmailJob.php`
- `app/Jobs/Emails/Purge/SecondWarningJob.php`
- `app/Jobs/Emails/SubscriptionDeletedEmailJob.php`
- `app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php`
- `app/Jobs/Emails/Subscriptions/UpcomingYearlyAlert.php`
- `app/Jobs/Emails/SubscriptionCancelEmailJob.php`
- `app/Jobs/Emails/Purge/FirstWarningJob.php`
- `app/Observers/UserObserver.php`
- `app/Http/Middleware/LocaleChange.php`
- `app/Http/Controllers/Billing/PaymentMethodController.php`

- [ ] **Step 1: Update each job file**

In each job, find `$user->log(UserAction::...)` and replace with `UserLogger::user($user)->log(UserAction::...)`. Add `use App\Facades\UserLogger;` to each file.

`app/Jobs/Emails/SubscriptionFailedEmailJob.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::failedChargeEmail);
```

`app/Jobs/Emails/Purge/SecondWarningJob.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::purgeWarningSecond);
```

`app/Jobs/Emails/SubscriptionDeletedEmailJob.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::subCancelAuto);
```

`app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::subPaypalExpiringWarning);
```

`app/Jobs/Emails/Subscriptions/UpcomingYearlyAlert.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::yearlyRenewWarning);
```

`app/Jobs/Emails/SubscriptionCancelEmailJob.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::subCancelManual);
```

`app/Jobs/Emails/Purge/FirstWarningJob.php`:
```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::purgeWarningFirst);
```

- [ ] **Step 2: Update `app/Observers/UserObserver.php`**

Find the three `$user->log(...)` calls (around lines 60–64) and replace each:

```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::emailUpdate);    // line ~60
UserLogger::user($user)->log(UserAction::socialSwitch);   // line ~62
UserLogger::user($user)->log(UserAction::passwordUpdate); // line ~64
```

- [ ] **Step 3: Update `app/Http/Middleware/LocaleChange.php`**

Find `$user->log(UserAction::lang, ['from' => $user->locale, 'to' => $locale])` (around line 78) and replace:

```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::lang, ['from' => $user->locale, 'to' => $locale]);
```

- [ ] **Step 4: Update `app/Http/Controllers/Billing/PaymentMethodController.php`**

Find `$user->log(UserAction::currencySwitch)` (around line 82) and replace:

```php
use App\Facades\UserLogger;
// ...
UserLogger::user($user)->log(UserAction::currencySwitch);
```

- [ ] **Step 5: Run tests**

```bash
vendor/bin/sail artisan test --compact
```

Expected: PASS.

- [ ] **Step 6: Commit**

```bash
git add app/Jobs/Emails/SubscriptionFailedEmailJob.php \
        app/Jobs/Emails/Purge/SecondWarningJob.php \
        app/Jobs/Emails/SubscriptionDeletedEmailJob.php \
        app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php \
        app/Jobs/Emails/Subscriptions/UpcomingYearlyAlert.php \
        app/Jobs/Emails/SubscriptionCancelEmailJob.php \
        app/Jobs/Emails/Purge/FirstWarningJob.php \
        app/Observers/UserObserver.php \
        app/Http/Middleware/LocaleChange.php \
        app/Http/Controllers/Billing/PaymentMethodController.php
git commit -m "refactor: use UserLogger facade in jobs, observers, middleware, and controller"
```

---

### Task 8: Remove log() and campaignLog() from User model, run pint, full test pass

**Files — Modify:**
- `app/Models/User.php`

- [ ] **Step 1: Verify no remaining callers**

```bash
grep -rn "->campaignLog\|->log(" app --include="*.php" | grep "user"
```

Expected: no output (or only commented-out code). If any results appear, update those callers before proceeding.

- [ ] **Step 2: Remove both methods from `app/Models/User.php`**

Delete the entire `log()` method (the one with `UserAction $action` parameter, around lines 265–279) and the entire `campaignLog()` method (around lines 281–300).

Also remove unused imports from the top of `User.php` if `UserLog` or `UserAction` are no longer referenced anywhere else in the file:

```bash
grep -n "UserLog\|UserAction" app/Models/User.php
```

Remove any import that's now unused.

- [ ] **Step 3: Run pint**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 4: Run the full test suite**

```bash
vendor/bin/sail artisan test --compact
```

Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add app/Models/User.php
git commit -m "refactor: remove log() and campaignLog() from User model"
```
