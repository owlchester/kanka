# Yearly Renewal Alert Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Alert yearly Stripe subscribers 14 days before renewal by handling the `invoice.upcoming` webhook event Stripe fires automatically.

**Architecture:** Add a `handleInvoiceUpcoming` method to the existing `WebhookController` (which already extends Cashier's `WebhookController`). The handler resolves the user, checks whether any invoice line item is a yearly plan price, and dispatches the existing `UpcomingYearlyAlert` job. No schema changes. No new daily commands.

**Tech Stack:** Laravel 11, Laravel Cashier v15, Stripe webhooks, existing `UpcomingYearlyAlert` job

---

## Pre-flight: Stripe Dashboard (Manual Step — Do This First)

In the Stripe Dashboard:
1. Go to **Billing → Settings**
2. Find **"Upcoming renewal reminders"** (or "Invoice settings" → "Days until invoice is finalized")
3. Set the lead time to **14 days**

This is what controls when Stripe fires `invoice.upcoming`. Without this step the webhook will never arrive. Confirm it is set before deploying the code change.

---

## File Map

| File | Change |
|------|--------|
| `app/Http/Controllers/WebhookController.php` | Add `handleInvoiceUpcoming` method + 2 new imports |

`app/Console/Kernel.php` — no change needed; `UpcomingYearlyCommand` is already commented out on line 62.

---

## Task 1: Add `handleInvoiceUpcoming` to `WebhookController`

**Files:**
- Modify: `app/Http/Controllers/WebhookController.php`

### Background

Cashier's base `WebhookController` routes incoming Stripe events to handler methods by converting the event name to camel case: `invoice.upcoming` → `handleInvoiceUpcoming`. You just need to define the method — Cashier finds it automatically.

The Stripe `invoice.upcoming` payload shape relevant to us:

```json
{
  "data": {
    "object": {
      "customer": "cus_xxx",
      "lines": {
        "data": [
          { "price": { "id": "price_xxx" } }
        ]
      }
    }
  }
}
```

The yearly plan price IDs live in `config('subscription.owlbear.yearly')`, `config('subscription.wyvern.yearly')`, and `config('subscription.elemental.yearly')` — each returns an array of price ID strings (including legacy `_OLD` variants).

- [ ] **Step 1: Add the two missing imports**

Open `app/Http/Controllers/WebhookController.php`. After the existing `use` block, add:

```php
use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use Symfony\Component\HttpFoundation\Response;
```

The full import block should look like:

```php
use App\Enums\UserAction;
use App\Jobs\Emails\SubscriptionDeletedEmailJob;
use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use App\Services\Subscription\PaymentMethodService;
use App\Services\SubscriptionService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;
```

- [ ] **Step 2: Add the `handleInvoiceUpcoming` method**

Add this method to `WebhookController`, after `handleCustomerSubscriptionDeleted` and before `isCancelling`:

```php
/**
 * Handle an upcoming invoice (yearly renewal warning).
 */
public function handleInvoiceUpcoming(array $payload): Response
{
    $data = $payload['data']['object'];
    $user = $this->getUserByStripeId($data['customer'] ?? null);

    if (! $user) {
        return $this->successMethod();
    }

    $yearlyPlans = array_merge(
        config('subscription.owlbear.yearly'),
        config('subscription.wyvern.yearly'),
        config('subscription.elemental.yearly'),
    );

    $lines = $data['lines']['data'] ?? [];
    $isYearly = collect($lines)->contains(
        fn ($line) => in_array($line['price']['id'] ?? null, $yearlyPlans)
    );

    if (! $isYearly) {
        return $this->successMethod();
    }

    UpcomingYearlyAlert::dispatch($user);

    return $this->successMethod();
}
```

- [ ] **Step 3: Run Pint to fix formatting**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Review and accept any formatting changes Pint makes.

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/WebhookController.php
git commit -m "feat: alert yearly subscribers 14 days before renewal via invoice.upcoming webhook"
```

---

## Task 2: Verify the Stripe Webhook Event Is Registered

**Files:** No code changes — verification only.

Stripe only sends `invoice.upcoming` events if the event type is enabled in your webhook endpoint configuration.

- [ ] **Step 1: Check webhook endpoint in Stripe Dashboard**

Go to **Developers → Webhooks** in the Stripe Dashboard. Open the webhook endpoint that points to your production URL (typically `https://kanka.io/stripe/webhook`).

Confirm `invoice.upcoming` is in the list of subscribed events. If it is not listed, click **Edit** and add it.

- [ ] **Step 2: Test with Stripe CLI (optional but recommended)**

If you have the Stripe CLI available, you can send a test event:

```bash
stripe trigger invoice.upcoming
```

Then check your application logs to confirm the handler was reached:

```bash
vendor/bin/sail artisan pail
```

You should see queue activity for `UpcomingYearlyAlert`. No actual email will be sent to a real user when using the test trigger, but the handler will run against a test customer.

---

## Notes

- The `UpcomingYearlyCommand` (`subscriptions:upcoming`) is already commented out of the scheduler in `app/Console/Kernel.php:62`. No change needed there.
- The `UpcomingYearlyAlert` job already handles the email send and logs `UserAction::yearlyRenewWarning` on the user — no additional logging needed in the webhook handler.
- Monthly invoices are silently ignored (the `$isYearly` check returns early).
- Deleted-account users are silently ignored (the `$user` null check returns early).
