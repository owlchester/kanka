# Yearly Subscription Renewal Alert — Design Spec

**Date:** 2026-04-09
**Status:** Approved

## Problem

Yearly subscribers receive no reliable renewal warning. The existing `UpcomingYearlyCommand` uses `updated_at` as a proxy for the renewal date, which is wrong — it changes whenever the subscription record changes. Cashier does not store `current_period_end` locally, so there is no clean local date to query against.

## Solution

Use Stripe's `invoice.upcoming` webhook event. Stripe fires this event a configurable number of days before each renewal. We add a handler to the existing `WebhookController` that checks whether the invoice is for a yearly plan and dispatches the existing `UpcomingYearlyAlert` job. No schema changes. No daily polling.

## Components

### 1. Stripe Dashboard (manual one-time step)

In the Stripe dashboard under **Billing → Settings → Manage failed payments**, set **"Days until invoice finalization"** (also referred to as the invoice upcoming lead time) to **14 days**. This controls how many days before renewal Stripe fires `invoice.upcoming`. This matches the existing PayPal expiry alert window.

### 2. `WebhookController::handleInvoiceUpcoming`

Add a new method to `app/Http/Controllers/WebhookController.php`:

- Receive the `invoice.upcoming` payload from Cashier
- Resolve the user via `stripe_id` from `payload['data']['object']['customer']` using the inherited `getUserByStripeId()` helper
- Extract the plan/price ID from the invoice lines (`payload['data']['object']['lines']['data'][0]['price']['id']`)
- Check whether the price ID is in any of the yearly plan lists from `config('subscription.*.yearly')`
- If yearly: dispatch `UpcomingYearlyAlert` and write a `UserLog` entry with `UserAction::notifyYearlySub`
- If not yearly (monthly invoice): return success silently
- If user not found: return success silently

### 3. `UpcomingYearlyCommand` (retirement)

Remove `subscriptions:upcoming` from the scheduler in `app/Console/Kernel.php`. The command file itself can be left in place as a dormant fallback but should not run automatically.

## Data Flow

```
Stripe (14 days before renewal)
  → POST /stripe/webhook  [invoice.upcoming]
  → Cashier routes to WebhookController::handleInvoiceUpcoming
  → Resolve user by stripe_id
  → Check price ID is in yearly plan list
  → Dispatch UpcomingYearlyAlert job
  → Job sends email + logs UserAction::yearlyRenewWarning
```

## Error Handling

- **User not found** (deleted account): bail silently, return `$this->successMethod()`
- **Non-yearly invoice**: return `$this->successMethod()` without dispatching
- **Missing price ID in payload**: log a warning and return `$this->successMethod()`

## Out of Scope

- Backfilling alerts for subscribers whose renewal is within the next 14 days at the time of deployment (they will simply not receive a warning this cycle)
- Any changes to the `UpcomingYearlyAlert` job or email template
- Schema changes
