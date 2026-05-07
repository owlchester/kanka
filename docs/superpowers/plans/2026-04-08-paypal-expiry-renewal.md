# PayPal Expiry Reminder & Renewal Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Send PayPal subscribers a 2-week expiry reminder email with a "what you'll lose" breakdown, and provide a dedicated renewal flow that extends `ends_at` by one year from the current expiry date (with optional tier upgrade).

**Architecture:** A new Artisan command dispatches a queued email job daily for users whose PayPal subscription expires in exactly 14 days. A new `PayPalRenewalService` handles the PayPal order and extends `ends_at = old_ends_at + 1 year`. A new `RenewalController` provides four routes. A `UserPolicy` method gates access, and a banner on the subscription settings page surfaces the renewal option in-app.

**Tech Stack:** Laravel 11, Laravel Cashier (Subscription model), `srmklive/paypal`, Blade markdown mail, Artisan scheduler

---

## File Map

| File | Action |
|---|---|
| `app/Enums/UserAction.php` | Edit — add `subPaypalExpiringWarning = 84` and `subPaypalRenew = 85` |
| `app/Console/Commands/Subscriptions/PaypalExpiringCommand.php` | Create |
| `app/Console/Kernel.php` | Edit — register daily schedule |
| `app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php` | Create |
| `app/Mail/Subscription/User/PaypalExpiringMail.php` | Create |
| `lang/en/emails/subscriptions/paypal-expiring.php` | Create |
| `resources/views/emails/subscriptions/paypal-expiring/user.blade.php` | Create |
| `app/Services/Subscription/PayPalRenewalService.php` | Create |
| `app/Http/Controllers/Subscription/PayPal/RenewalController.php` | Create |
| `routes/settings.php` | Edit — add 4 PayPal renewal routes |
| `resources/views/settings/subscription/paypal-renew.blade.php` | Create |
| `app/Policies/UserPolicy.php` | Edit — add `renewPaypalSubscription` method |
| `resources/views/settings/subscription/index.blade.php` | Edit — add renewal banner |

---

## Task 1: Add UserAction enum cases

**Files:**
- Modify: `app/Enums/UserAction.php`

- [ ] **Step 1: Add the two new cases**

Open `app/Enums/UserAction.php`. After line `case yearlyRenewWarning = 81;`, add:

```php
    case subPaypalExpiringWarning = 84;
    case subPaypalRenew = 85;
```

The block around it should look like:

```php
    case failedChargeEmail = 80;
    case yearlyRenewWarning = 81;
    case subCancelManual = 82;
    case subCancelAuto = 83;
    case subPaypalExpiringWarning = 84;
    case subPaypalRenew = 85;
    case paymentEdit = 86;
```

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Enums/UserAction.php
git commit -m "feat: add PayPal expiry warning and renewal UserAction cases"
```

---

## Task 2: Artisan command — PaypalExpiringCommand

**Files:**
- Create: `app/Console/Commands/Subscriptions/PaypalExpiringCommand.php`

- [ ] **Step 1: Create the file**

```php
<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Emails\Subscriptions\PaypalExpiringAlert;
use App\Models\User;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PaypalExpiringCommand extends Command
{
    use HasJobLog;

    protected $signature = 'subscriptions:paypal-expiring';

    protected $description = 'Alert PayPal subscribers whose subscription expires in 14 days';

    protected int $count = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $target = Carbon::now()->addDays(14)->toDateString();
        $log = "Looking for PayPal subscriptions expiring on {$target}";
        $this->info($log);

        User::whereHas('subscriptions', function ($query) use ($target): void {
            $query->where('stripe_price', 'like', 'paypal_%')
                ->whereDate('ends_at', $target);
        })
            ->chunk(100, function ($users): void {
                foreach ($users as $user) {
                    $this->notify($user);
                }
            });

        $this->info('Alerted ' . $this->count . ' subscribers.');
        $log .= '<br />' . 'Alerted ' . $this->count . ' subscribers.';

        $this->log($log);

        return 0;
    }

    protected function notify(User $user): void
    {
        if (! $user->subscribed('kanka')) {
            return;
        }

        PaypalExpiringAlert::dispatch($user);
        $this->count++;
    }
}
```

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Console/Commands/Subscriptions/PaypalExpiringCommand.php
git commit -m "feat: add PaypalExpiringCommand to alert expiring PayPal subscribers"
```

---

## Task 3: Register the command in the scheduler

**Files:**
- Modify: `app/Console/Kernel.php`

- [ ] **Step 1: Add the import**

At the top of `app/Console/Kernel.php`, add alongside the other subscription command imports:

```php
use App\Console\Commands\Subscriptions\PaypalExpiringCommand;
```

- [ ] **Step 2: Register the schedule**

Inside `protected function schedule(Schedule $schedule): void`, add after the `EndFreeTrials` line:

```php
$schedule->command(PaypalExpiringCommand::class)->onOneServer()->dailyAt('06:30')->sentryMonitor();
```

- [ ] **Step 3: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 4: Commit**

```bash
git add app/Console/Kernel.php
git commit -m "feat: schedule PaypalExpiringCommand daily at 06:30"
```

---

## Task 4: Email job — PaypalExpiringAlert

**Files:**
- Create: `app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php`

- [ ] **Step 1: Create the file**

```php
<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Enums\UserAction;
use App\Mail\Subscription\User\PaypalExpiringMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaypalExpiringAlert implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $userId;

    public function __construct(User $user)
    {
        $this->userId = $user->id;
    }

    public function handle(): void
    {
        /** @var User|null $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        Mail::to($user->email)
            ->locale($user->locale)
            ->send(new PaypalExpiringMail($user));

        $user->log(UserAction::subPaypalExpiringWarning);
    }
}
```

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Jobs/Emails/Subscriptions/PaypalExpiringAlert.php
git commit -m "feat: add PaypalExpiringAlert queued email job"
```

---

## Task 5: Translation keys for the expiry email

**Files:**
- Create: `lang/en/emails/subscriptions/paypal-expiring.php`

- [ ] **Step 1: Create the file**

```php
<?php

return [
    'title'   => 'Your Kanka subscription expires soon',
    'dear'    => 'Dear :name',
    'intro'   => 'Your Kanka PayPal subscription expires on **:date**. After that date your account will revert to the free tier.',
    'loss'    => [
        'title'   => 'Here is what you will lose:',
        'campaign' => 'Premium campaign **:campaign**|Premium campaigns **:campaign** and :count more',
        'players'  => ':count player will lose access|:count players will lose access',
        'plugins'  => ':count marketplace plugin|:count marketplace plugins',
        'ads'      => 'Ad-free experience',
        'discord'  => 'Your **:role** Discord role',
    ],
    'cta'     => 'Renew your subscription',
    'closing' => 'Yours truly,',
];
```

- [ ] **Step 2: Commit**

```bash
git add lang/en/emails/subscriptions/paypal-expiring.php
git commit -m "feat: add translation keys for PayPal expiry reminder email"
```

---

## Task 6: Email mailable — PaypalExpiringMail

**Files:**
- Create: `app/Mail/Subscription/User/PaypalExpiringMail.php`

- [ ] **Step 1: Create the file**

The constructor gathers "what you'll lose" data the same way `CancellationController::index()` does, so the template receives pre-computed variables.

```php
<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PaypalExpiringMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public string $expiryDate;

    public ?string $premiumCampaignName;

    public int $premiumCampaignCount;

    public int $players;

    public int $plugins;

    public bool $discord;

    public string $renewUrl;

    public function __construct(User $user)
    {
        $this->user = $user;

        $subscription = $user->subscription('kanka');
        $this->expiryDate = $subscription->ends_at->isoFormat('MMMM D, Y');
        $this->renewUrl = route('paypal.renew');

        $this->discord = (bool) $user->discord();

        /** @var Collection $premiumCampaigns */
        $premiumCampaigns = $user->boosts()
            ->with([
                'campaign' => fn ($sub) => $sub->select('campaigns.id', 'campaigns.name'),
                'campaign.members',
                'campaign.plugins',
            ])
            ->groupBy('campaign_id')
            ->get();

        $firstCampaign = $premiumCampaigns->first();
        $this->premiumCampaignName = $firstCampaign?->campaign?->name;
        $this->premiumCampaignCount = $premiumCampaigns->count();

        $members = new Collection;
        $this->plugins = 0;

        if ($firstCampaign) {
            foreach ($firstCampaign->campaign->members as $member) {
                $members->push($member->user_id);
            }
            $this->plugins = $firstCampaign->campaign->plugins->count();
        }

        $this->players = $members->unique()->reject(fn ($userId) => $userId === $user->id)->count();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/subscriptions/paypal-expiring.title'),
            tags: ['user', 'paypal-expiring'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.paypal-expiring.user',
        );
    }
}
```

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Mail/Subscription/User/PaypalExpiringMail.php
git commit -m "feat: add PaypalExpiringMail mailable with loss data"
```

---

## Task 7: Email Blade template

**Files:**
- Create: `resources/views/emails/subscriptions/paypal-expiring/user.blade.php`

- [ ] **Step 1: Create the file**

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

<x-mail::button :url="$renewUrl">
{{ __('emails/subscriptions/paypal-expiring.cta') }}
</x-mail::button>

{{ __('emails/subscriptions/paypal-expiring.closing') }}

__Jay & Jon_

</x-mail::message>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/emails/subscriptions/paypal-expiring/user.blade.php
git commit -m "feat: add PayPal expiry reminder email template"
```

---

## Task 8: PayPalRenewalService

**Files:**
- Create: `app/Services/Subscription/PayPalRenewalService.php`

- [ ] **Step 1: Create the file**

```php
<?php

namespace App\Services\Subscription;

use App\Enums\UserAction;
use App\Models\Tier;
use App\Traits\UserAware;
use Srmklive\PayPal\Services\PayPal;

class PayPalRenewalService
{
    use UserAware;

    protected Tier $tier;

    public function tier(Tier $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    public function process(): mixed
    {
        $currency = 'USD';
        if ($this->user->billedInEur()) {
            $currency = 'EUR';
        }

        $price = $this->tier->yearly;

        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        return $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.renew-success'),
                'cancel_url' => route('paypal.renew-cancel'),
            ],
            'purchase_units' => [
                0 => [
                    'reference_id' => $this->tier->name,
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $price,
                    ],
                ],
            ],
        ]);
    }

    public function renew(Tier $tier): void
    {
        $sub = $this->user->subscriptions()->first();
        $sub->ends_at = $sub->ends_at->addYear();
        $sub->stripe_price = 'paypal_' . $tier->code;
        $sub->save();

        $this->user->pledge = $tier->name;
        $this->user->save();

        $this->user->log(UserAction::subPaypalRenew);
    }
}
```

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Services/Subscription/PayPalRenewalService.php
git commit -m "feat: add PayPalRenewalService with process and renew methods"
```

---

## Task 9: Routes

**Files:**
- Modify: `routes/settings.php`

- [ ] **Step 1: Add the import at the top of the file**

Open `routes/settings.php`. Find the existing `use App\Http\Controllers\PayPalController;` import and add below it:

```php
use App\Http\Controllers\Subscription\PayPal\RenewalController;
```

- [ ] **Step 2: Add routes after the existing PayPal block**

Find the existing PayPal routes block (around line 173–178). Directly after it, add:

```php
/*
--------------------------------------------------------------------------
PayPal Renewal
--------------------------------------------------------------------------
*/

Route::get('subscription/paypal/renew', [RenewalController::class, 'index'])
    ->name('paypal.renew');
Route::post('subscription/paypal/renew/{tier}', [RenewalController::class, 'process'])
    ->name('paypal.renew-process');
Route::get('subscription/paypal/renew/success', [RenewalController::class, 'success'])
    ->name('paypal.renew-success');
Route::get('subscription/paypal/renew/cancel', [RenewalController::class, 'cancel'])
    ->name('paypal.renew-cancel');
```

- [ ] **Step 3: Commit**

```bash
git add routes/settings.php
git commit -m "feat: add PayPal renewal routes"
```

---

## Task 10: RenewalController

**Files:**
- Create: `app/Http/Controllers/Subscription/PayPal/RenewalController.php`

- [ ] **Step 1: Create the file**

```php
<?php

namespace App\Http\Controllers\Subscription\PayPal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidatePledge;
use App\Models\Tier;
use App\Services\Subscription\PayPalRenewalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class RenewalController extends Controller
{
    public function __construct(protected PayPalRenewalService $service)
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $this->authorize('renewPaypalSubscription', $user);

        $tiers = Tier::ordered()->get()->reject(fn (Tier $tier) => $tier->isFree());

        return view('settings.subscription.paypal-renew', compact('user', 'tiers'));
    }

    public function process(ValidatePledge $request, Tier $tier)
    {
        $this->authorize('renewPaypalSubscription', $request->user());

        if ($tier->isFree()) {
            abort(401);
        }

        $response = $this->service
            ->user($request->user())
            ->tier($tier)
            ->process();

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        Log::error('PayPal renewal process error', $response);

        return redirect()
            ->route('settings.subscription')
            ->with('error', __('subscriptions/paypal.errors.failed') . ' ' . __('subscriptions/paypal.errors.contact', ['email' => config('app.email')]));
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $tierName = $response['purchase_units']['0']['reference_id'];
            $tier = Tier::where('name', $tierName)->firstOrFail();

            Log::info('PayPal renewal', $response);

            $this->service
                ->user($request->user())
                ->renew($tier);

            return redirect()
                ->route('settings.subscription')
                ->with('success', __('subscriptions.renew.success'));
        }

        Log::error('PayPal renewal capture error', $response);

        return redirect()
            ->route('settings.subscription')
            ->with('error', __('subscriptions/paypal.errors.incomplete') . ' ' . __('subscriptions/paypal.errors.contact', ['email' => config('app.email')]));
    }

    public function cancel()
    {
        return redirect()
            ->route('settings.subscription')
            ->with('error', __('settings.subscription.errors.callback'));
    }
}
```

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/Subscription/PayPal/RenewalController.php
git commit -m "feat: add PayPal RenewalController"
```

---

## Task 11: Renewal view

**Files:**
- Create: `resources/views/settings/subscription/paypal-renew.blade.php`

- [ ] **Step 1: Create the file**

```blade
<?php
/**
 * @var \App\Models\User $user
 * @var \Illuminate\Database\Eloquent\Collection|\App\Models\Tier[] $tiers
 */
?>
@extends('layouts.app', [
    'title' => __('subscriptions/renew.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
<x-grid type="1/1">
    <h1 class="text-2xl">{{ __('subscriptions/renew.title') }}</h1>

    <x-helper>
        <p>
            {!! __('subscriptions/paypal-renew.intro', [
                'date' => '<strong>' . $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') . '</strong>',
            ]) !!}
        </p>
    </x-helper>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($tiers as $tier)
            <article class="rounded-2xl bg-box flex flex-col gap-4 p-4 relative shadow-xs hover:shadow-md @if ($tier->isCurrent($user)) border-primary border @endif">
                <div class="flex gap-2 items-center">
                    <img src="{{ $tier->image() }}" alt="{{ $tier->name }}" class="w-10 h-10" />
                    <h2 class="text-xl m-0">{{ $tier->name }}</h2>
                    @if ($tier->isCurrent($user))
                        <span class="badge badge-primary badge-sm">{{ __('tiers.current') }}</span>
                    @endif
                </div>

                @include('settings.subscription.tiers.benefits._' . strtolower($tier->name))

                @if (!$user->isElemental() || !$tier->isCurrent($user))
                    @php
                        $isDowngrade = match($user->pledge) {
                            'Elemental' => in_array($tier->name, ['Owlbear', 'Wyvern']),
                            'Wyvern'    => $tier->name === 'Owlbear',
                            default     => false,
                        };
                    @endphp

                    @if (!$isDowngrade)
                        <x-form :action="['paypal.renew-process', 'tier' => $tier]" class="mt-auto">
                            <x-buttons.confirm type="primary" class="btn-block">
                                {{ $tier->isCurrent($user)
                                    ? __('subscriptions/renew.actions.renew')
                                    : __('tiers.actions.subscribe.upgrade', ['tier' => $tier->name]) }}
                            </x-buttons.confirm>
                        </x-form>
                    @endif
                @endif
            </article>
        @endforeach
    </div>
</x-grid>
@endsection
```

- [ ] **Step 2: Add the translation file for the renewal page**

Create `lang/en/subscriptions/paypal-renew.php`:

```php
<?php

return [
    'intro' => 'Your subscription expires on :date. Renewing will extend your access for one full year from that date.',
];
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/settings/subscription/paypal-renew.blade.php lang/en/subscriptions/paypal-renew.php
git commit -m "feat: add PayPal renewal page view and translations"
```

---

## Task 12: UserPolicy — renewPaypalSubscription

**Files:**
- Modify: `app/Policies/UserPolicy.php`

- [ ] **Step 1: Add the method**

Open `app/Policies/UserPolicy.php` and add the method after the `freeTrial` method:

```php
    public function renewPaypalSubscription(User $authUser, User $user): bool
    {
        if (! $user->hasPayPal()) {
            return false;
        }

        $subscription = $user->subscription('kanka');
        if (! $subscription) {
            return false;
        }

        return $subscription->ends_at->lte(now()->addDays(14));
    }
```

`lte(now()->addDays(14))` returns true when `ends_at` is within the next 14 days (or already in the past).

- [ ] **Step 2: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 3: Commit**

```bash
git add app/Policies/UserPolicy.php
git commit -m "feat: add renewPaypalSubscription policy method to UserPolicy"
```

---

## Task 13: Subscription settings page — renewal banner

**Files:**
- Modify: `resources/views/settings/subscription/index.blade.php`

- [ ] **Step 1: Add the banner**

Open `resources/views/settings/subscription/index.blade.php`. Find the line:

```blade
        @include('partials.errors')
```

Add the following block directly after it:

```blade
        @can('renewPaypalSubscription', $user)
            <x-alert type="warning">
                <p class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <span>
                        {!! __('settings.subscription.paypal_expiring', [
                            'date' => '<strong>' . $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') . '</strong>',
                        ]) !!}
                    </span>
                    <a href="{{ route('paypal.renew') }}" class="btn2 btn-warning btn-sm whitespace-nowrap">
                        {{ __('subscriptions/renew.actions.renew') }}
                    </a>
                </p>
            </x-alert>
        @endcan
```

- [ ] **Step 2: Add the translation key**

Open `lang/en/settings.php`. Find the `'subscription' => [` array. Add inside it:

```php
'paypal_expiring' => 'Your PayPal subscription expires on :date. Renew now to avoid losing access.',
```

- [ ] **Step 3: Format**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 4: Commit**

```bash
git add resources/views/settings/subscription/index.blade.php lang/en/settings.php
git commit -m "feat: add PayPal expiry renewal banner to subscription settings page"
```

---

## Done

All four features are now in place:

1. `subscriptions:paypal-expiring` runs daily and dispatches `PaypalExpiringAlert` for users expiring in 14 days
2. `PaypalExpiringMail` sends a personalised email with loss details and a renewal CTA
3. The PayPal renewal flow (`/subscription/paypal/renew`) lets users extend by one year from their current `ends_at`, with optional tier upgrade
4. The subscription settings page shows a `x-alert` banner during the 2-week window, gated by `UserPolicy::renewPaypalSubscription`

> **Reminder:** Run `vendor/bin/sail yarn run build` or `vendor/bin/sail composer run dev` so the frontend picks up any asset changes.
