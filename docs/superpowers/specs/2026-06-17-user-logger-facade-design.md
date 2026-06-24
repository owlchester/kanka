# UserLogger Facade Design

**Date:** 2026-06-17
**Status:** Approved

## Problem

`User::log()` and `User::campaignLog()` both live on the `User` model and directly persist `UserLog` records. This violates single-responsibility — the model shouldn't know how to log itself. Both methods already carry `// todo: move to a facade` comments. All ~20 callers in listeners must hold a `User` instance just to write a log entry.

## Goal

Extract both methods into a `UserLogger` facade backed by a dedicated service, using the `UserAware` trait for fluent method chaining. Remove both methods from the `User` model.

## Architecture

### New files

- `app/Services/Logs/UserLoggerService.php` — holds the logging logic; uses `UserAware` trait
- `app/Facades/UserLogger.php` — facade pointing to `UserLoggerService`

### Registration

Bind `UserLoggerService` as a singleton in `AppServiceProvider` (or an existing log-focused provider if one exists).

### API

```php
// User-level events (login, subscription changes, etc.)
UserLogger::user($user)->log(UserAction $action, array $data = []): void

// Campaign admin events (members, roles, exports, etc.)
UserLogger::user($user)->campaign(int $campaignId, string $module, string $action, array $data = []): void
```

`UserAware` provides `user(User $user): self`, enabling fluent chaining. The `logging.enabled` config guard and `Identity::getImpersonatorId()` live inside the service — callers don't need to care.

### Null-user callers

One listener (`LogEntity`) currently uses `$event->user?->campaignLog(...)`. With the new API, `user()` accepts `User`, not `?User`, so this caller adds an explicit null guard:

```php
if ($event->user) {
    UserLogger::user($event->user)->campaign(...);
}
```

## Changes

### `app/Services/Logs/UserLoggerService.php` (new)

```php
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

### `app/Facades/UserLogger.php` (new)

Standard facade pointing to `UserLoggerService`.

### `app/Models/User.php`

Remove `log()` and `campaignLog()` methods.

### Callers (~22 total)

| Location | Change |
|---|---|
| `app/Listeners/Campaigns/*/Log*.php` (~16 files) | `$event->user->campaignLog(...)` → `UserLogger::user($event->user)->campaign(...)` |
| `app/Listeners/Entities/LogEntity.php` | Add null guard, use `UserLogger::user($event->user)->campaign(...)` |
| `app/Listeners/Posts/LogPost.php` | `$event->user->log(...)` → `UserLogger::user($event->user)->log(...)` |
| `app/Listeners/Users/Subscriptions/LogPremium.php` | `$event->user->campaignLog(...)` → `UserLogger::user($event->user)->campaign(...)` |
| `app/Services/Campaign/ModuleEditService.php` | `$this->user->campaignLog(...)` → `UserLogger::user($this->user)->campaign(...)` |
| `app/Services/Onboarding/InitialService.php` | `$this->user->campaignLog(...)` → `UserLogger::user($this->user)->campaign(...)` |

## Testing

- Existing listener/service tests cover the call paths. Update any test that calls `$user->campaignLog()` or `$user->log()` directly to use the facade.
- Add a unit test for `UserLoggerService` covering: config guard short-circuits, `log()` persists correct `UserLog`, `campaign()` persists correct `UserLog` with impersonator.
