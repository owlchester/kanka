# Stripe Native PayPal Migration Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Sunset the direct PayPal integration by blocking old PayPal renewal and new direct PayPal subscriptions, while wiring in Stripe's PaymentElement so PayPal-via-Stripe becomes the new path for everyone.

**Architecture:** Existing PayPal subscribers keep their data and receive the expiry email but can no longer renew via the old flow. The checkout `change.blade.php` drops the card/PayPal method-selector in favour of a single Stripe `PaymentElement` (which surfaces card and Stripe-PayPal in one unified UI). A new return-URL controller action completes Stripe-PayPal subscriptions after the off-site redirect.

**Tech Stack:** Laravel 11, Cashier v15, Stripe.js v3, Tailwind CSS v4, Blade

## Global Constraints

- PHP 8.4 — use constructor property promotion, explicit return types, union types
- No new Composer dependencies
- All commands run via `vendor/bin/sail`
- All PHP files formatted with `vendor/bin/sail bin pint --dirty --format agent` before commit
- Tests: Pest v3, run with `vendor/bin/sail artisan test --compact`
- Never hardcode user-facing strings — use `__()` with existing or new lang keys
- `hasPayPal()` on `User` must NOT be removed — existing subscriber checks throughout the app depend on it
- Do not touch `PaypalExpiringCommand`, `PaypalExpiringAlert` job, or `PaypalExpiringMail` mailable — only the email template and its lang strings change
- Do not remove `PayPalService`, `PayPalRenewalService`, `PayPalController`, or `RenewalController` — redirect them gracefully rather than deleting

---

### Task 1: Block PayPal renewal — policy, routes, index alert

The `@can('renewPaypalSubscription')` alert in the subscription index shows existing PayPal users a "Renew now" button 14 days before expiry. The `paypal.renew*` routes serve the renewal flow. Block both.

**Files:**
- Modify: `app/Policies/UserPolicy.php` (method `renewPaypalSubscription`)
- Modify: `resources/views/settings/subscription/index.blade.php` (lines 29–42)
- Modify: `app/Http/Controllers/Subscription/PayPal/RenewalController.php` (`index` method)

**Interfaces:**
- Produces: `renewPaypalSubscription` always returns `false`; the alert is gone from the index; hitting `paypal.renew` redirects away with an informational message

- [ ] **Step 1: Write failing test for policy**

Create `tests/Feature/Policies/UserPolicyPaypalRenewTest.php`:

```php
<?php

use App\Models\User;
use App\Policies\UserPolicy;

it('blocks paypal renewal regardless of subscription state', function () {
    $user = User::factory()->create();

    $policy = new UserPolicy;

    expect($policy->renewPaypalSubscription($user))->toBeFalse();
});
```

- [ ] **Step 2: Run test to confirm it fails**

```bash
vendor/bin/sail artisan test --compact --filter=UserPolicyPaypalRenewTest
```

Expected: FAIL — `renewPaypalSubscription` currently returns `true` for eligible users.

- [ ] **Step 3: Update the policy**

In `app/Policies/UserPolicy.php`, replace the `renewPaypalSubscription` body:

```php
public function renewPaypalSubscription(User $user): bool
{
    return false;
}
```

- [ ] **Step 4: Run test — expect pass**

```bash
vendor/bin/sail artisan test --compact --filter=UserPolicyPaypalRenewTest
```

- [ ] **Step 5: Remove the alert from the index view**

In `resources/views/settings/subscription/index.blade.php`, delete lines 29–42 (the entire `@can('renewPaypalSubscription')` block):

```blade
{{-- DELETE this entire block --}}
@can('renewPaypalSubscription', $user)
    <x-alert type="warning">
        ...
    </x-alert>
@endcan
```

- [ ] **Step 6: Redirect the renewal controller**

In `app/Http/Controllers/Subscription/PayPal/RenewalController.php`, update `index()`:

```php
public function index(Request $request): \Illuminate\Http\RedirectResponse
{
    return redirect()
        ->route('settings.subscription')
        ->with('info', __('subscriptions/paypal-renew.errors.deprecated'));
}
```

Add the new lang key to `lang/en/subscriptions/paypal-renew.php`:

```php
return [
    'errors'    => [
        'deprecated'    => 'PayPal renewal is no longer available. Please subscribe using a card or PayPal through our updated checkout.',
        'permission'    => 'Your subscription isn\'t set to expire in the next 14 days.',
    ],
    'intro'     => 'Your subscription expires on :date. ...',
    'success'   => 'Your subscription has been renewed successfully until :date.',
];
```

- [ ] **Step 7: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Policies/UserPolicy.php \
        app/Http/Controllers/Subscription/PayPal/RenewalController.php \
        resources/views/settings/subscription/index.blade.php \
        lang/en/subscriptions/paypal-renew.php \
        tests/Feature/Policies/UserPolicyPaypalRenewTest.php
git commit -m "feat: block legacy PayPal renewal flow"
```

---

### Task 2: Update the PayPal expiry email

Keep the "your subscription is expiring" notification but remove the renew CTA button. Add a line pointing to the normal subscription page so users know they can re-subscribe via Stripe.

**Files:**
- Modify: `lang/en/emails/subscriptions/paypal-expiring.php`
- Modify: `resources/views/emails/subscriptions/paypal-expiring/user.blade.php`
- Modify: `app/Mail/Subscription/User/PaypalExpiringMail.php` (remove `$renewUrl`)

**Interfaces:**
- Consumes: nothing new
- Produces: email renders without a CTA button; `PaypalExpiringMail` no longer exposes a public `$renewUrl`

- [ ] **Step 1: Write failing test**

Create `tests/Feature/Mail/PaypalExpiringMailTest.php`:

```php
<?php

use App\Mail\Subscription\User\PaypalExpiringMail;
use App\Models\User;

it('does not expose a renew url', function () {
    $user = User::factory()->create();

    $mail = new PaypalExpiringMail($user);

    expect(property_exists($mail, 'renewUrl'))->toBeFalse();
});

it('renders without a renew button', function () {
    $user = User::factory()->create();

    $rendered = (new PaypalExpiringMail($user))->render();

    expect($rendered)->not->toContain(route('paypal.renew'));
});
```

- [ ] **Step 2: Run tests — expect fail**

```bash
vendor/bin/sail artisan test --compact --filter=PaypalExpiringMailTest
```

- [ ] **Step 3: Remove `$renewUrl` from the mailable**

In `app/Mail/Subscription/User/PaypalExpiringMail.php`, remove:

```php
// DELETE these two lines
public string $renewUrl;
// ...
$this->renewUrl = route('paypal.renew');
```

- [ ] **Step 4: Update lang strings**

Replace `lang/en/emails/subscriptions/paypal-expiring.php`:

```php
<?php

return [
    'closing'   => 'Yours truly,',
    'cta'       => 'Resubscribe via Kanka',
    'dear'      => 'Dear :name',
    'intro'     => 'Your Kanka PayPal subscription expires on **:date**. After that date your account will revert to the free tier.',
    'resubscribe' => 'You can resubscribe at any time using a card or PayPal through our subscription page.',
    'loss'      => [
        'ads'       => 'Ad-free experience',
        'campaign'  => 'Premium campaign **:campaign**|Premium campaigns **:campaign** and :count more',
        'discord'   => 'Your **:role** Discord role',
        'players'   => ':count player will lose access|:count players will lose access',
        'plugins'   => ':count plugin|:count plugins',
        'title'     => 'Here is what you will lose:',
    ],
    'title'     => 'Your Kanka subscription expires soon',
];
```

- [ ] **Step 5: Update the email template**

Replace `resources/views/emails/subscriptions/paypal-expiring/user.blade.php`:

```blade
<x-mail::message>

{{ __('emails/subscriptions/paypal-expiring.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/paypal-expiring.intro', ['date' => $expiryDate]) }}

{{ __('emails/subscriptions/paypal-expiring.loss.title') }}

@if ($premiumCampaignName)
- {{ trans_choice('emails/subscriptions/paypal-expiring.loss.campaign', $premiumCampaignCount - 1, ['campaign' => $premiumCampaignName, 'count' => $premiumCampaignCount - 1]) }}
@if ($players > 0)
  - {{ trans_choice('emails/subscriptions/paypal-expiring.loss.players', $players, ['count' => $players]) }}
@endif
@if ($plugins > 0)
  - {{ trans_choice('emails/subscriptions/paypal-expiring.loss.plugins', $plugins, ['count' => $plugins]) }}
@endif
@endif
- {{ __('emails/subscriptions/paypal-expiring.loss.ads') }}
@if ($discord)
- {{ __('emails/subscriptions/paypal-expiring.loss.discord', ['role' => $user->pledge]) }}
@endif

{{ __('emails/subscriptions/paypal-expiring.resubscribe') }}

<x-mail::button :url="route('settings.subscription')">
{{ __('emails/subscriptions/paypal-expiring.cta') }}
</x-mail::button>

{{ __('emails/subscriptions/paypal-expiring.closing') }}

__Jay & Jon__

</x-mail::message>
```

- [ ] **Step 6: Run tests — expect pass**

```bash
vendor/bin/sail artisan test --compact --filter=PaypalExpiringMailTest
```

- [ ] **Step 7: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Mail/Subscription/User/PaypalExpiringMail.php \
        lang/en/emails/subscriptions/paypal-expiring.php \
        resources/views/emails/subscriptions/paypal-expiring/user.blade.php \
        tests/Feature/Mail/PaypalExpiringMailTest.php
git commit -m "feat: remove PayPal renewal CTA from expiry email"
```

---

### Task 3: Remove the direct-PayPal checkout panel

The `change.blade.php` currently has a method-selector dropdown and two panels (card, PayPal). Remove the selector and the direct-PayPal panel. Clean up the JS that toggled between them. The card panel stays but will be replaced by PaymentElement in Task 4.

**Files:**
- Modify: `resources/views/settings/subscription/change.blade.php`
- Modify: `resources/js/subscription.js`
- Modify: `app/Http/Controllers/Settings/SubscriptionController.php` (`change` method — remove `$limited`)
- Modify: `lang/en/settings.php` — remove `paypal_v3` and `paypal_expiring` strings

**Interfaces:**
- Consumes: nothing from previous tasks
- Produces: `change.blade.php` no longer renders the method selector or PayPal panel; `$limited` is not passed to the view; `subscription.js` has no `changeMethod` function

- [ ] **Step 1: Remove the method selector and PayPal panel from the view**

In `resources/views/settings/subscription/change.blade.php`:

Delete the entire `<div class="flex flex-col gap-2">` method selector block (lines 59–70):

```blade
{{-- DELETE this block --}}
<div class="flex flex-col gap-2">
    <select name="select-method" class="select">
        @if (! $limited)
            <option value="card">...</option>
        @endif
        <option value="paypal">PayPal</option>
    </select>
</div>
```

Delete the entire PayPal panel (the `<div ... id="paypal-panel">` block, lines 161–224).

Remove the `@if (! $limited)` / `@endif` wrappers around the card panel (lines 72 and 160), keeping the card panel content intact. The card panel becomes unconditional.

Also remove the `hasPayPal()` branch in the description area (lines 23–29) — replace with the same upgrade/downgrade text used for Stripe users.

The description area (lines 30–43) should become:

```blade
@if ($isDowngrading)
    {!! __('settings.subscription.change.text.downgrade_' . ($period->isYearly() ? 'yearly' : 'monthly'), [
        'downgrade' => "<strong>$currency<span id='pricing-now'>" . \Illuminate\Support\Number::format($upgrade, 2) . "</span></strong>",
        'tier' => "<strong>$tier->name</strong>",
        'amount' => "<strong>$currency$amount</strong>"
    ]) !!}
@else
    {!! __('settings.subscription.change.text.upgrade_' . ($period->isYearly() ? 'yearly' : 'monthly'), [
        'upgrade' => "<strong>$currency<span id='pricing-now'>" . \Illuminate\Support\Number::format($upgrade, 2) . "</span></strong>",
        'tier' => "<strong>$tier->name</strong>",
        'amount' => "<strong>$currency$amount</strong>"
    ]) !!}
@endif
```

- [ ] **Step 2: Remove `$limited` from the controller**

In `app/Http/Controllers/Settings/SubscriptionController.php`, in the `change()` method, delete:

```php
// DELETE these lines
$limited = $this->subscription->isLimited();
if ($user->hasPayPal() || $user->hasManualSubscription()) {
    $limited = true;
}
```

Remove `'limited'` from the `compact()` call in the same method.

- [ ] **Step 3: Remove PayPal JS from subscription.js**

In `resources/js/subscription.js`:

- Delete the `changeMethod` function entirely (lines 83–94)
- Remove `paypalCoupon` from the variable declarations at the top
- Remove `paypalCoupon = document.querySelector('.paypal-coupon');` from `initConfirmListener`
- Remove the `selectMethod` event listener block (lines 77–80) from `initConfirmListener`
- Remove all `paypalCoupon.classList.add/remove('hidden')` calls from `checkCoupon`

- [ ] **Step 4: Remove stale lang strings**

In `lang/en/settings.php`, remove:
- `'paypal_v3'` key under `settings.subscription`
- `'paypal_expiring'` key under `settings.subscription`
- `'upgrade_paypal'` key under `settings.subscription.change.text`

In `lang/en/subscriptions/confirm.php`, remove:
- `'paypal'` key under `actions`
- `'none'` key under `helpers.auto-renew`
- `'paypal'` key under `helpers`

- [ ] **Step 5: Verify the page still renders**

```bash
vendor/bin/sail artisan test --compact --filter=Subscription
```

Manually open the subscription page in a browser and confirm no console errors and the card panel renders.

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add resources/views/settings/subscription/change.blade.php \
        resources/js/subscription.js \
        app/Http/Controllers/Settings/SubscriptionController.php \
        lang/en/settings.php \
        lang/en/subscriptions/confirm.php
git commit -m "feat: remove direct PayPal checkout panel"
```

---

### Task 4: Replace CardElement with PaymentElement

Stripe's `PaymentElement` is a single unified element that shows card fields, PayPal, and any other payment methods enabled in your Stripe Dashboard — no code change needed to add/remove methods. It requires passing `clientSecret` to `stripe.elements()` upfront.

**Files:**
- Modify: `resources/views/settings/subscription/change.blade.php`
- Modify: `resources/js/subscription.js`

**Interfaces:**
- Consumes: `$intent->client_secret` already passed to the view by `SubscriptionController::change()`
- Produces: checkout renders a `PaymentElement`; submit handler uses `stripe.confirmSetup` with `redirect: 'if_required'`; for PayPal (redirect), it stores the pending subscription before redirecting

**Note on existing saved cards:** The current flow shows saved-card users their card details and skips the element entirely. Keep this path intact — only show PaymentElement when `$card` is null (no saved payment method).

- [ ] **Step 1: Update the view**

In `resources/views/settings/subscription/change.blade.php`, inside the `@if (!$card)` block, replace the card-name input and `#card-element` div:

```blade
{{-- Before --}}
<x-forms.field field="card-name" :label="__('settings.subscription.payment_method.card_name')">
    <input type="text" name="card-holder-name"  />
</x-forms.field>

<x-forms.field field="card-number" :label="__('settings.subscription.payment_method.card')">
    <div id="card-element" class=""></div>
</x-forms.field>
```

```blade
{{-- After --}}
<div id="payment-element"></div>
```

Also add a hidden input for the Stripe intent client secret so JS can pick it up:

```blade
<input type="hidden" id="stripe-setup-intent" value="{{ $intent->client_secret }}" />
```

(The existing `subscription-intent-token` hidden input already carries this — you can reuse it instead of adding a new one. Confirm the existing input is still present and use that in JS.)

- [ ] **Step 2: Update `initStripe` in subscription.js**

Replace the `initStripe` function:

```javascript
// Initialize the stripe API
const initStripe = () => {
    const token = document.getElementById('stripe-token');
    if (!token) return;
    stripe = Stripe(token.value);
    // Elements are initialised in initConfirmListener once we have the client secret
};
```

- [ ] **Step 3: Update `initConfirmListener` in subscription.js**

Replace the `cardSelector` block (the part that mounts the card element):

```javascript
const initConfirmListener = () => {
    formSubmitBtn = document.querySelector('.subscription-confirm-button');

    const intentInput = document.querySelector('input[name="subscription-intent-token"]');
    const paymentElementContainer = document.getElementById('payment-element');

    if (paymentElementContainer && intentInput && !elements) {
        // Initialise PaymentElement with the SetupIntent client secret
        elements = stripe.elements({ clientSecret: intentInput.value });
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
    }

    document.getElementById('subscription-confirm')?.addEventListener('submit', subscribe);

    couponField = document.getElementById('coupon-check');
    if (couponField) {
        couponSuccess = document.getElementById('coupon-success');
        couponError = document.getElementById('coupon-invalid');
        couponId = document.getElementById('coupon');
        couponValidating = document.getElementById('coupon-validating');
        couponField.addEventListener('change', checkCoupon);
        couponField.addEventListener('focusout', checkCoupon);
    }
};
```

- [ ] **Step 4: Update the `subscribe` function in subscription.js**

Replace the `subscribe` function:

```javascript
const subscribe = (event) => {
    const form = event.target;
    event.preventDefault();
    disableSubmit(event);

    const errorMessage = document.querySelector('.alert-error');
    errorMessage.classList.add('hidden');

    // User already has a saved payment method — submit directly
    const cardID = document.querySelector('input[name="payment_id"]');
    if (cardID && cardID.value) {
        form.submit();
        return;
    }

    // Store pending subscription info in session before any PayPal redirect
    const periodInput = document.querySelector('input[name="period"]');
    const couponInput = document.getElementById('coupon');
    const returnUrl = new URL(window.subscriptionReturnUrl);
    if (periodInput) returnUrl.searchParams.set('period', periodInput.value);
    if (couponInput && couponInput.value) returnUrl.searchParams.set('coupon', couponInput.value);

    stripe.confirmSetup({
        elements,
        confirmParams: {
            return_url: returnUrl.toString(),
        },
        redirect: 'if_required',
    }).then((result) => {
        if (result.error) {
            formSubmitBtn.classList.remove('disabled', 'loading');
            formSubmitBtn.disabled = '';
            errorMessage.innerHTML = result.error.message;
            errorMessage.classList.remove('hidden');
            return;
        }

        // Card payment completed without redirect — set payment_id and submit
        if (result.setupIntent && result.setupIntent.payment_method) {
            cardID.value = result.setupIntent.payment_method;
            form.submit();
        }
    });
};
```

Add `window.subscriptionReturnUrl` to the change view so JS knows the return URL (set in Task 5):

```blade
<script>
    window.subscriptionReturnUrl = "{{ route('settings.subscription.payment-return', ['tier' => $tier]) }}";
</script>
```

- [ ] **Step 5: Check the page loads without JS errors**

```bash
vendor/bin/sail artisan test --compact --filter=Subscription
```

Open the subscription change modal in a browser (dev tools open). Confirm PaymentElement renders with card fields visible. Confirm no console errors.

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add resources/views/settings/subscription/change.blade.php \
        resources/js/subscription.js
git commit -m "feat: replace CardElement with Stripe PaymentElement"
```

---

### Task 5: Handle Stripe PayPal return redirect

When a user selects PayPal in the PaymentElement, `stripe.confirmSetup` redirects them off-site. On return, Stripe appends `setup_intent_client_secret` to the `return_url`. A new controller action retrieves the setup intent, extracts the payment method, and completes the subscription.

**Files:**
- Modify: `routes/settings.php`
- Modify: `app/Http/Controllers/Settings/SubscriptionController.php` (add `paymentReturn` action)

**Interfaces:**
- Consumes: `route('settings.subscription.payment-return', ['tier' => $tier])` with query params `period`, `coupon`, `setup_intent_client_secret` (appended by Stripe)
- Produces: on success → redirect to `settings.subscription.finish`; on failure → redirect to `settings.subscription` with error

- [ ] **Step 1: Add the route**

In `routes/settings.php`, inside the subscription route group, add:

```php
Route::get('subscription/payment-return/{tier}', [\App\Http\Controllers\Settings\SubscriptionController::class, 'paymentReturn'])
    ->name('settings.subscription.payment-return');
```

- [ ] **Step 2: Write a failing test**

Create `tests/Feature/Settings/SubscriptionPaymentReturnTest.php`:

```php
<?php

use App\Models\Tier;
use App\Models\User;

it('redirects to subscription page when setup_intent_client_secret is missing', function () {
    $user = User::factory()->create();
    $tier = Tier::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', ['tier' => $tier]))
        ->assertRedirect(route('settings.subscription'));
});
```

- [ ] **Step 3: Run test — expect fail (route not found)**

```bash
vendor/bin/sail artisan test --compact --filter=SubscriptionPaymentReturnTest
```

- [ ] **Step 4: Add `paymentReturn` to `SubscriptionController`**

```php
public function paymentReturn(Request $request, Tier $tier): \Illuminate\Http\RedirectResponse
{
    $clientSecret = $request->get('setup_intent_client_secret');

    if (empty($clientSecret)) {
        return redirect()
            ->route('settings.subscription')
            ->withError(__('settings.subscription.errors.failed', ['email' => config('app.email')]));
    }

    try {
        /** @var \Stripe\SetupIntent $setupIntent */
        $setupIntent = $request->user()->stripe()->setupIntents->retrieve($clientSecret);

        if ($setupIntent->status !== 'succeeded') {
            return redirect()
                ->route('settings.subscription')
                ->withError(__('settings.subscription.errors.callback'));
        }

        $paymentMethodId = is_string($setupIntent->payment_method)
            ? $setupIntent->payment_method
            : $setupIntent->payment_method->id;

        $period = $request->get('period') === 'yearly' ? PricingPeriod::Yearly : PricingPeriod::Monthly;

        $this->subscription->user($request->user())
            ->tier($tier)
            ->period($period)
            ->coupon($request->get('coupon'))
            ->request(['payment_id' => $paymentMethodId])
            ->change()
            ->finish();

        return redirect()
            ->route('settings.subscription.finish')
            ->with('sub_tracking', 'subscribed')
            ->with('sub_value', $this->subscription->subscriptionValue())
            ->with('sub_coupon', $request->get('coupon'))
            ->with('sub_id', $this->subscription->tierPrice()->id);

    } catch (IncompletePayment $exception) {
        session()->put('subscription_callback', $paymentMethodId ?? null);

        return redirect()->route(
            'cashier.payment',
            // @phpstan-ignore-next-line
            [$exception->payment->id, 'redirect' => route('settings.subscription.callback')]
        );
    } catch (TranslatableException $e) {
        return redirect()
            ->route('settings.subscription')
            ->with('error_raw', $e->getTranslatedMessage());
    } catch (Exception $e) {
        return redirect()
            ->route('settings.subscription')
            ->withError(__('settings.subscription.errors.failed', ['email' => config('app.email')]));
    }
}
```

Note: `$request->user()->stripe()` returns the `\Stripe\StripeClient` instance via Cashier's `stripe()` method on the `Billable` trait. If this method is not available, use `\Stripe\SetupIntent::retrieve($clientSecret, ['api_key' => config('cashier.secret')])` instead.

- [ ] **Step 5: Run test — expect pass**

```bash
vendor/bin/sail artisan test --compact --filter=SubscriptionPaymentReturnTest
```

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add routes/settings.php \
        app/Http/Controllers/Settings/SubscriptionController.php \
        tests/Feature/Settings/SubscriptionPaymentReturnTest.php
git commit -m "feat: add Stripe PayPal return URL handler"
```

---

### Task 6: Fix subscription index and tier action views for legacy PayPal users

The index view hides the monthly/yearly period toggle for PayPal users. The tier action views have a `@if ($user->hasPayPal())` branch that shows a single old-PayPal button. Both need updating so legacy PayPal subscribers see the normal Stripe UI (the period toggle, and standard upgrade/downgrade buttons that lead to the PaymentElement checkout).

**Files:**
- Modify: `resources/views/settings/subscription/index.blade.php`
- Modify: `resources/views/settings/subscription/tiers/actions/_owlbear.blade.php`
- Modify: `resources/views/settings/subscription/tiers/actions/_wyvern.blade.php`
- Modify: `resources/views/settings/subscription/tiers/actions/_elemental.blade.php`
- Modify: `resources/views/settings/subscription/_recap.blade.php`

**Interfaces:**
- Produces: PayPal users see the same period toggle and pricing grid as Stripe users; the `_recap` partial shows their billing amount

- [ ] **Step 1: Update the index period toggle**

In `resources/views/settings/subscription/index.blade.php`, change line 54 from:

```blade
@if (!$isPayPal && !$hasManual)
```

to:

```blade
@if (!$hasManual)
```

Change line 68 — remove `$isPayPal ||` from the grid class:

```blade
{{-- Before --}}
@if ($isPayPal || $hasManual) period-year @else period-month @endif

{{-- After --}}
@if ($hasManual) period-year @else period-month @endif
```

- [ ] **Step 2: Remove the PayPal branch from each tier action view**

In each of `_owlbear.blade.php`, `_wyvern.blade.php`, and `_elemental.blade.php`, the top-level structure is:

```blade
@if ($user->hasPayPal())
    ... single PayPal-specific button ...
@else
    ... normal Stripe monthly/yearly buttons ...
@endif
```

Delete the `@if ($user->hasPayPal()) ... @else` and the closing `@endif`, keeping only the content that was in the `@else` block. Do this for all three files.

For `_owlbear.blade.php` the result should be:

```blade
@php
/**
 * @var \App\Models\User $user
 * @var \App\Models\Tier $tier
 */
@endphp
@if($user->subscribedToPrice($tier->monthlyPlans(), 'kanka'))
    <a class="btn2 btn-block disabled price-monthly">
        {{ __('tiers.current') }}
    </a>
@else
    <a
        class="btn2 btn-block btn-primary price-monthly"
        data-toggle="dialog"
        data-target="subscribe-confirm"
        data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'monthly']) }}"
        data-id="{{ $tier->code . '-monthly' }}"
        data-name="{{ $tier->name }} Monthly"
        data-price="{{ $tier->price($user->currency(), \App\Enums\PricingPeriod::Monthly) }}"
    >
        @if (in_array($tier->id, $downgrades))
            {{ __('tiers.actions.subscribe.downgrade', ['tier' => $tier->name]) }}
        @else
            {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
        @endif
    </a>
@endif

@if($user->subscribedToPrice($tier->yearlyPlans(), 'kanka'))
    <a class="btn2 btn-block disabled price-yearly">
        {{ __('tiers.current') }}
    </a>
@else
    <a
        class="btn2 btn-block btn-primary price-yearly"
        data-toggle="dialog"
        data-target="subscribe-confirm"
        data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'yearly']) }}"
        data-id="{{ $tier->code . '-yearly' }}"
        data-name="{{ $tier->name }} Yearly"
        data-price="{{ $tier->price($user->currency(), \App\Enums\PricingPeriod::Yearly) }}"
    >
        @if (in_array($tier->id, $upgrades))
            {{ __('tiers.actions.subscribe.upgrade', ['tier' => $tier->name]) }}
        @elseif (in_array($tier->id, $downgrades))
            {{ __('tiers.actions.subscribe.downgrade', ['tier' => $tier->name]) }}
        @else
            {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
        @endif
    </a>
@endif
```

- [ ] **Step 3: Fix `_recap.blade.php` billing display for PayPal users**

In `resources/views/settings/subscription/_recap.blade.php`, the `@if (!$user->hasPayPal())` guard (which hides the billing amount box for PayPal users) can be removed so PayPal users also see their plan cost. Remove the `@if (!$user->hasPayPal())` ... `@endif` wrapper around the billing box (lines ~47–63). The billing box already handles `empty($current)` gracefully.

- [ ] **Step 4: Remove `$isPayPal` and `$hasManual` from index controller if now unused**

In `app/Http/Controllers/Settings/SubscriptionController.php`, in the `index()` method, check if `$isPayPal` is still referenced in `index.blade.php`. If not (after the changes above), remove `$isPayPal = $user->hasPayPal();` and remove `'isPayPal'` from the `compact()` call.

`$hasManual` is still used (for the period toggle and grid class), so keep it.

- [ ] **Step 5: Run all subscription tests**

```bash
vendor/bin/sail artisan test --compact --filter=Subscription
```

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add resources/views/settings/subscription/index.blade.php \
        resources/views/settings/subscription/_recap.blade.php \
        resources/views/settings/subscription/tiers/actions/_owlbear.blade.php \
        resources/views/settings/subscription/tiers/actions/_wyvern.blade.php \
        resources/views/settings/subscription/tiers/actions/_elemental.blade.php \
        app/Http/Controllers/Settings/SubscriptionController.php
git commit -m "feat: show Stripe checkout UI for legacy PayPal subscribers"
```

---

### Task 7: Clean up unused PayPal lang keys and the `paypal-renew` view

Remove translation keys that are no longer referenced after the previous tasks. Remove the `paypal-renew.blade.php` view (the renewal page is now blocked at the controller level).

**Files:**
- Delete: `resources/views/settings/subscription/paypal-renew.blade.php`
- Modify: `lang/en/subscriptions/paypal-renew.php` (keep only the `deprecated` and error keys)

**Interfaces:**
- Produces: no orphaned views or unreferenced lang keys for the PayPal renewal path

- [ ] **Step 1: Delete the renew view**

```bash
rm resources/views/settings/subscription/paypal-renew.blade.php
```

Confirm the `RenewalController::index()` (updated in Task 1) redirects before ever rendering a view.

- [ ] **Step 2: Trim the paypal-renew lang file**

Replace `lang/en/subscriptions/paypal-renew.php` with only the keys still in use:

```php
<?php

return [
    'errors'    => [
        'deprecated'    => 'PayPal renewal is no longer available. Please subscribe using a card or PayPal through our updated checkout.',
        'permission'    => 'Your subscription isn\'t set to expire in the next 14 days.',
    ],
];
```

(The `intro` and `success` keys were only used in the now-deleted view and in the blocked controller flow.)

- [ ] **Step 3: Run full test suite to confirm nothing regressed**

```bash
vendor/bin/sail artisan test --compact
```

- [ ] **Step 4: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add lang/en/subscriptions/paypal-renew.php
git rm resources/views/settings/subscription/paypal-renew.blade.php
git commit -m "chore: remove stale PayPal renewal view and lang keys"
```

---

---

### Task 8: Remove card expiry tracking — delete PII from the database

The `card_expires_at` column on `users` stores a user's card expiration date. It's used by a scheduled command that emails users 30 days before expiry. Stripe's own Dashboard setting (Settings → Billing → Customer emails → "Expiring card") handles this automatically — enable that, then delete every line of code that reads or writes this column.

**Pre-requisite (manual):** In your Stripe Dashboard, go to Settings → Billing → Emails and enable "Expiring card" notifications. Stripe will email customers directly. Do this before deploying this task.

**Files to delete:**
- `app/Console/Commands/Subscriptions/ExpiringCardCommand.php`
- `app/Jobs/Emails/Subscriptions/ExpiringCardAlert.php`
- `app/Mail/Subscription/User/ExpiringCardEmail.php`
- `resources/views/emails/subscriptions/expiring/user-md.blade.php` (and `expiring/` directory if empty)
- `lang/en/emails/subscriptions/expiring.php` (and all other locale copies: `de`, `es`, `fr`, `it`, `pl`, `pt-BR`, `ru`, `sk`)

**Files to modify:**
- Create: new migration to drop the column
- Modify: `app/Console/Kernel.php`
- Modify: `app/Console/Commands/Tests/TestEmail.php`
- Modify: `app/Models/User.php`
- Modify: `app/Services/SubscriptionService.php`
- Modify: `app/Services/Subscription/PaymentMethodService.php`
- Modify: `app/Http/Controllers/Settings/SubscriptionApiController.php`
- Modify: `app/Http/Controllers/Billing/PaymentMethodController.php`

**Interfaces:**
- Produces: `card_expires_at` column dropped; no code writes or reads it; the scheduled command and email stack are gone

- [ ] **Step 1: Create migration to drop the column**

```bash
vendor/bin/sail artisan make:migration drop_card_expires_at_from_users --no-interaction
```

In the generated file under `database/migrations/`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex('idx_card_expires_at');
            $table->dropColumn('card_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dateTime('card_expires_at')->nullable();
            $table->index(['card_expires_at'], 'idx_card_expires_at');
        });
    }
};
```

- [ ] **Step 2: Run migration**

```bash
vendor/bin/sail artisan migrate
```

Expected: `card_expires_at` column gone from `users` table.

- [ ] **Step 3: Remove the property and cast from `User` model**

In `app/Models/User.php`:

- Remove `* @property ?Carbon $card_expires_at` from the PHPDoc block
- Remove `'card_expires_at'` from the `$hidden` array
- Remove `'card_expires_at' => 'datetime'` from the `casts()` method (or `$casts` property)

- [ ] **Step 4: Remove card expiry from `SubscriptionService`**

In `app/Services/SubscriptionService.php`, in the `change()` method, remove the expiry lines while preserving the BRL VPN check. The block becomes:

```php
// Save the expiration date on the user for alerts about expiring cards
$payment = $this->user->defaultPaymentMethod();
if ($payment instanceof PaymentMethod) {
    /** @var Card $card */
    $card = $payment->asStripePaymentMethod()->card;

    // Check that someone isn't using a VPN
    if (app()->isProduction() && $this->user->currency() === 'brl' && $card?->country !== 'BR') {
        throw (new TranslatableException('subscription.errors.invalid_card_country.brl'))->setOptions(['email' => '<a href="mailto:' . config('app.email') . '" class="text-link">' . config('app.email') . '</a>']);
    }
}
```

Note the `$card?->country` null-safe operator — `card` will be `null` for PayPal payment methods, so the VPN check skips gracefully.

Also remove the now-unused `$expiresAt` variable and the `$this->user->save()` call that was only there to persist it.

- [ ] **Step 5: Remove from `PaymentMethodService`**

In `app/Services/Subscription/PaymentMethodService.php`, delete the entire `card_expires_at` block (roughly lines 16–25). The method should call `$user->saveQuietly()` and log without touching the column.

- [ ] **Step 6: Remove from `SubscriptionApiController`**

In `app/Http/Controllers/Settings/SubscriptionApiController.php`:

- Around line 73–77: remove the `$expiresAt` calculation and `$user->card_expires_at = $expiresAt; $user->save();`
- Around line 81: remove `$user->card_expires_at = null;`
- Around line 130: remove `$user->card_expires_at = null;`

- [ ] **Step 7: Remove from `PaymentMethodController`**

In `app/Http/Controllers/Billing/PaymentMethodController.php`, around line 81, remove `$user->card_expires_at = null;`.

- [ ] **Step 8: Remove the scheduled command**

In `app/Console/Kernel.php`:

- Remove the `use App\Console\Commands\Subscriptions\ExpiringCardCommand;` import
- Remove `$schedule->command(ExpiringCardCommand::class)->onOneServer()->monthly();`

- [ ] **Step 9: Remove from the test email command**

In `app/Console/Commands/Tests/TestEmail.php`:

- Remove `use App\Jobs\Emails\Subscriptions\ExpiringCardAlert;`
- Remove the `ExpiringCardAlert` case from the command's email-type switch/list

- [ ] **Step 10: Delete the dead files**

```bash
rm app/Console/Commands/Subscriptions/ExpiringCardCommand.php
rm app/Jobs/Emails/Subscriptions/ExpiringCardAlert.php
rm app/Mail/Subscription/User/ExpiringCardEmail.php
rm resources/views/emails/subscriptions/expiring/user-md.blade.php
rmdir resources/views/emails/subscriptions/expiring/ 2>/dev/null || true
rm lang/en/emails/subscriptions/expiring.php
rm lang/de/emails/subscriptions/expiring.php
rm lang/es/emails/subscriptions/expiring.php
rm lang/fr/emails/subscriptions/expiring.php
rm lang/it/emails/subscriptions/expiring.php
rm lang/pl/emails/subscriptions/expiring.php
rm lang/pt-BR/emails/subscriptions/expiring.php
rm lang/ru/emails/subscriptions/expiring.php
rm lang/sk/emails/subscriptions/expiring.php
```

- [ ] **Step 11: Run full test suite**

```bash
vendor/bin/sail artisan test --compact
```

Expected: all tests pass; no references to `card_expires_at` remain.

- [ ] **Step 12: Verify no stale references**

```bash
grep -rn "card_expires_at\|ExpiringCardAlert\|ExpiringCardEmail\|ExpiringCardCommand" /Users/jay/Documents/GitHub/kanka/app /Users/jay/Documents/GitHub/kanka/resources /Users/jay/Documents/GitHub/kanka/lang
```

Expected: no output.

- [ ] **Step 13: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add -A
git commit -m "feat: remove card expiry tracking, delegate to Stripe hosted emails"
```

---

## Self-Review

**Spec coverage:**

| Requirement | Covered by |
|---|---|
| Block existing PayPal renewal | Task 1 (policy, index alert, controller redirect) |
| Block new subscriptions via old PayPal code | Task 3 (remove panel from change view) |
| Keep expiry email, remove "renew early" CTA | Task 2 |
| Add Stripe PaymentElement to checkout | Task 4 |
| Handle Stripe PayPal return redirect | Task 5 |
| Update various texts | Tasks 2, 3, 6, 7 (lang key removals and additions) |
| Existing PayPal subscribers untouched | `hasPayPal()` preserved; subscriber data untouched |

**Things NOT in scope (intentional):**
- `BillingManagement.vue` (manage payment methods page) — still uses CardElement; separate PR
- Enabling PayPal in Stripe Dashboard — manual step, no code change needed
- Migrating existing PayPal subscriber data to Stripe — out of scope; they expire naturally

**Potential gotcha:** `$request->user()->stripe()` in Task 5 — verify this method exists on Cashier's `Billable` trait in v15. If not, fall back to `\Stripe\SetupIntent::retrieve($clientSecret, ['api_key' => config('cashier.secret')])`.
