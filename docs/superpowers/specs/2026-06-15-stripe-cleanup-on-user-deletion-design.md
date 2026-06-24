# Stripe Cleanup on User Deletion

**Date:** 2026-06-15

## Overview

When a user deletes their account, Kanka must clean up their Stripe customer data. Currently the `DeleteUser` job removes all local data but the Stripe customer object (`cus_xxx`) persists indefinitely, retaining PII (name, email, payment methods). This violates GDPR and Stripe best practices.

## Rules

- Users who **never subscribed** (have a `stripe_id` but no entries in the `subscriptions` table) → **delete** the Stripe customer object entirely.
- Users who **did subscribe** (active or historical subscriptions) → **anonymize** the Stripe customer, preserving invoice/tax history but removing PII.
- Users with no `stripe_id` → skip entirely.
- Subscription cancellation before deletion is intentional and out of scope — users are expected to cancel before deleting their account.

## Architecture

### Where

Add `removeStripeCustomer()` as the final step in `CleanupService::delete()`, called just before the caller (`DeleteUser` job) issues `$user->delete()`.

This keeps Stripe API calls async (off the web request), consistent with all other cleanup, and retryable via the job queue.

### Retry

Add `public int $tries = 3;` to `DeleteUser` job. Safe because:
- `$user->delete()` only runs after `CleanupService->delete()` completes
- If Stripe throws, the exception fires before the user row is deleted
- On retry, `User::find($this->user)` still finds the user
- The existing "user not found" guard (line 42) handles any edge case where the user is already gone

## Logic

```
removeStripeCustomer():
  if !$user->hasStripeId() → return

  if $user->subscriptions()->exists():
    anonymize in Stripe
  else:
    delete from Stripe (catch resource_missing → return)
```

### Anonymize

Call `$user->updateStripeCustomer()` with:
- `name` → `"Deleted User"`
- `email` → `"deleted+{stripe_id}@kanka.io"` (unique per customer, avoids collisions)

Idempotent — calling twice with the same values is a no-op in Stripe.

### Delete

Call `$user->deleteStripeCustomer()` (Cashier built-in).

Catch `Stripe\Exception\InvalidRequestException` where the error code is `resource_missing` and return silently — handles the case where the customer was already deleted on a prior attempt before the exception fired.

## Files Changed

| File | Change |
|------|--------|
| `app/Services/Users/CleanupService.php` | Add `removeStripeCustomer()` method, call it last in `delete()` |
| `app/Jobs/Users/DeleteUser.php` | Add `public int $tries = 3;` |

## Out of Scope

- Subscription cancellation logic in `DeletionService` — intentional, no change
- Purge flow — already skips users with `stripe_id`, no change needed
