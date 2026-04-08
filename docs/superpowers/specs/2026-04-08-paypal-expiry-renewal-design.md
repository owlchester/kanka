# PayPal Subscription Expiry Reminder & Renewal — Design Spec

**Date:** 2026-04-08
**Status:** Approved

## Overview

PayPal subscribers receive a one-year, non-auto-renewing subscription. This feature adds:

1. A 2-week expiry reminder email with "what you'll lose" detail and a renewal CTA
2. A dedicated PayPal renewal flow allowing users to buy an extra year (with optional tier upgrade)
3. A warning banner on the subscription settings page during the 2-week window
4. A `UserPolicy` method gating access to the renewal flow

---

## Section 1: Artisan Command

**File:** `app/Console/Commands/Subscriptions/PaypalExpiringCommand.php`
**Signature:** `subscriptions:paypal-expiring`
**Schedule:** Daily in `app/Console/Kernel.php` (with Sentry monitoring, consistent with `EndSubscriptions`)

Finds all users with a PayPal subscription (`stripe_price LIKE 'paypal_%'`) whose `ends_at` falls exactly 14 days from today. Chunks results and dispatches a `PaypalExpiringAlert` job per user. Uses the `HasJobLog` trait and chunk pattern consistent with `ExpiringCardCommand`.

---

## Section 2: Email

### Job
**File:** `app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php`

Follows the same structure as `UpcomingYearlyAlert`: stores user ID, re-fetches in `handle()`, bails if user deleted, sends the mailable with the user's locale, logs `UserAction::subPaypalExpiringWarning`.

### Mailable
**File:** `app/Mail/Subscription/User/PaypalExpiringMail.php`

Constructor gathers the same loss data as `CancellationController::index()`:
- Premium campaign name + player count + plugin count (from `$user->boosts()` relation)
- Discord connection status
- Expiry date (`$subscription->ends_at`)
- Renewal URL (`route('paypal.renew')`)

Passes all data to the Blade template. Uses tags `['user', 'paypal-expiring']`.

### Template
**File:** `resources/views/emails/subscriptions/paypal-expiring/user.blade.php`

Markdown mail. Content:
- **Subject:** translated via `emails/subscriptions/paypal-expiring.title`
- Body: expiry date, bulleted list of what will be lost (campaign boosts with player/plugin counts if applicable, ad-free experience, Discord role if connected)
- CTA button linking to `paypal.renew`

Translation keys live under `lang/*/emails/subscriptions/paypal-expiring.php`.

### Enum
Add `subPaypalExpiringWarning` case to `app/Enums/UserAction.php` (consistent with `yearlyRenewWarning = 81`).

---

## Section 3: Renewal Flow

### Service
**File:** `app/Services/PayPalRenewalService.php`

Uses the `UserAware` trait. Two public methods:

**`process(): mixed`**
- Resolves currency from `$user->billedInEur()`
- Charges the full yearly tier price (no proration — this is a clean new year)
- Creates a PayPal order with `return_url = paypal.renew-success`, `cancel_url = paypal.renew-cancel`
- `reference_id` = tier name (same pattern as `PayPalService`)

**`renew(string $pledge): void`**
- Loads the user's existing PayPal subscription via `$user->subscriptions()->first()`
- Sets `ends_at = old_ends_at->addYear()`
- Updates `stripe_price = 'paypal_' . $pledge`
- Updates `user->pledge = $pledge`
- Saves both records
- Logs `UserAction::subPaypalRenew`

### Controller
**File:** `app/Http/Controllers/PayPalRenewalController.php`

Middleware: `['auth', 'identity']`

| Method | Route | Description |
|---|---|---|
| `index()` | `GET paypal.renew` | Shows renewal page; authorises via `UserPolicy::renewPaypalSubscription` |
| `processRenewal(ValidatePledge, Tier)` | `POST paypal.renew-process` | Calls `PayPalRenewalService::process()`, redirects to PayPal approval URL |
| `successRenewal(Request)` | `GET paypal.renew-success` | Captures payment order, calls `renew($pledge)`, redirects to `settings.subscription` with success flash |
| `cancelRenewal()` | `GET paypal.renew-cancel` | Redirects to `settings.subscription` with error flash |

### Routes
Added alongside existing PayPal routes in `routes/settings.php`:

```
GET  /subscription/paypal/renew              paypal.renew
POST /subscription/paypal/renew/{tier}       paypal.renew-process
GET  /subscription/paypal/renew/success      paypal.renew-success
GET  /subscription/paypal/renew/cancel       paypal.renew-cancel
```

### View
**File:** `resources/views/settings/subscription/paypal-renew.blade.php`

Tier picker pre-selected on user's current tier. Allows upgrading to a higher tier; does not allow downgrading (they are buying a full new year at the chosen tier). Reuses existing tier benefit partials where possible. PayPal button per eligible tier posts to `paypal.renew-process`.

### Enum
Add `subPaypalRenew` case to `app/Enums/UserAction.php`.

---

## Section 4: Settings Page Banner & Policy

### Policy Method
**File:** `app/Policies/UserPolicy.php` (existing)

Add method `renewPaypalSubscription(User $authUser, User $user): bool`:
- User must have a PayPal subscription (`$user->hasPayPal()`)
- Subscription `ends_at` must be within 14 days from now

Both the banner and `PayPalRenewalController::index()` authorise against this policy method. Controller aborts 403 if unauthorised.

### Banner
**File:** `resources/views/settings/subscription/index.blade.php`

Add `@can('renewPaypalSubscription', $user)` block rendering a warning helper banner showing the expiry date and a button linking to `paypal.renew`. Positioned prominently (above tier cards).

---

## File Summary

| File | Action |
|---|---|
| `app/Console/Commands/Subscriptions/PaypalExpiringCommand.php` | New |
| `app/Console/Kernel.php` | Edit — register daily schedule |
| `app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php` | New |
| `app/Mail/Subscription/User/PaypalExpiringMail.php` | New |
| `resources/views/emails/subscriptions/paypal-expiring/user.blade.php` | New |
| `lang/*/emails/subscriptions/paypal-expiring.php` | New |
| `app/Enums/UserAction.php` | Edit — add two cases |
| `app/Services/PayPalRenewalService.php` | New |
| `app/Http/Controllers/PayPalRenewalController.php` | New |
| `routes/settings.php` | Edit — add 4 routes |
| `resources/views/settings/subscription/paypal-renew.blade.php` | New |
| `app/Policies/UserPolicy.php` | Edit — add policy method |
| `resources/views/settings/subscription/index.blade.php` | Edit — add banner |
