<?php

namespace App\Services;

use App\Enums\PricingPeriod;
use App\Exceptions\TranslatableException;
use App\Jobs\DiscordRoleJob;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Jobs\Emails\SubscriptionCreatedEmailJob;
use App\Jobs\Emails\SubscriptionDowngradedEmailJob;
use App\Jobs\Emails\Subscriptions\WelcomeSubscriptionEmailJob;
use App\Models\Pledge;
use App\Models\Role;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Traits\UserAware;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Cashier\PaymentMethod;
use Stripe\Card;
use Stripe\Stripe;

class SubscriptionService
{
    use UserAware;

    public const STATUS_UNSUBSCRIBED = 0;

    public const STATUS_SUBSCRIBED = 1;

    public const STATUS_GRACE = 2;

    public const STATUS_CANCELLED = 3;

    protected Tier $tier;

    protected TierPrice $tierPrice;

    /** @var string|null */
    protected $plan = null;

    protected PricingPeriod $period;

    /** @var bool set to true if the request comes from a webhook */
    protected bool $webhook = false;

    /** @var bool if the user has cancelled */
    protected bool $cancelled = false;

    /** @var string applied coupon */
    protected string $coupon;

    /** Value of the subscription */
    protected float $subscriptionValue = 0;

    /** @var array|Request The request object */
    protected $request;

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function tier(Tier $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function period(PricingPeriod $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function yearly(): self
    {
        $this->period = PricingPeriod::Yearly;

        return $this;
    }

    public function monthly(): self
    {
        $this->period = PricingPeriod::Monthly;

        return $this;
    }

    /**
     * @return $this
     */
    public function webhook(): self
    {
        $this->webhook = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function request(array $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return $this
     */
    public function coupon(?string $coupon = null): self
    {
        if ($this->period === PricingPeriod::Yearly && ! empty($coupon)) {
            $this->coupon = $coupon;
        }

        return $this;
    }

    /**
     * When the stripe API calls us, we get a plan_id that needs to be transformed into a tier and tierprice
     *
     * @return $this
     */
    public function plan(string $plan): self
    {
        // Some weird edge cases in prod need mapping
        if ($plan === 'price_1IRIwTDInN4WlDnRJJU53rej') {
            $plan = config('subscription.owlbear.usd.monthly');
        }
        /** @var ?TierPrice $price */
        $price = TierPrice::where('stripe_id', $plan)->first();
        $this->tier = $price->tier;

        return $this;
    }

    /**
     * Change plans
     */
    public function change(): self
    {
        // Update the user's payment plan
        $paymentMethodID = Arr::get($this->request, 'payment_id');
        $this->user->addPaymentMethod($paymentMethodID);
        $this->user->updateDefaultPaymentMethod($paymentMethodID);

        // Save the expiration date on the user for alerts about expiring cards
        $payment = $this->user->defaultPaymentMethod();
        if ($payment instanceof PaymentMethod) {
            /** @var Card $card */
            $card = $payment->asStripePaymentMethod()->card;
            $expiresAt = Carbon::createFromDate($card->exp_year, $card->exp_month)->endOfMonth();
            $this->user->card_expires_at = $expiresAt;
            $this->user->save();

            // Check that someone isn't using a VPN
            if (app()->isProduction() && $this->user->currency() === 'brl' && $card->country !== 'BR') {
                throw (new TranslatableException('subscription.errors.invalid_card_country.brl'))->setOptions(['email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>']);
            }
        }

        // Subscribe
        $this->subscribe($paymentMethodID);

        return $this;
    }

    /**
     * @return $this
     *
     * @throws \Laravel\Cashier\Exceptions\IncompletePayment
     */
    public function subscribe(string $paymentID): self
    {
        // New subscriber
        if (! $this->user->subscribed('kanka')) {
            $this->user->newSubscription('kanka', $this->tierPrice()->stripe_id)
                ->withCoupon($this->coupon ?? null)
                ->create($paymentID);

            $this->user->log(UserLog::TYPE_SUB_NEW);

            return $this;
        }

        // If going down from elemental to owlbear, keep it as is until the current billing period
        if ($this->downgrading()) {
            $this->user->subscription('kanka')->swap($this->tierPrice()->stripe_id);
            $this->user->log(UserLog::TYPE_SUB_DOWNGRADE);
        } else {
            $this->user->subscription('kanka')->swapAndInvoice($this->tierPrice()->stripe_id);
            $this->user->log(UserLog::TYPE_SUB_UPGRADE);
        }

        return $this;
    }

    public function renew(): void
    {
        $this->user->subscription('kanka')->resume();
    }

    /**
     * Setup the user's pledge, role, discord
     *
     * @return $this
     */
    public function finish(): self
    {

        // If the user is cancelling through the interface, don't do anything else
        if ($this->cancelled) {
            return $this;
        }

        // If downgrading, send admins an email, and let stripe deal with the rest. A user update hook will be thrown
        // when the user really changes. Probably?
        if (! $this->webhook && $this->downgrading()) {
            SubscriptionDowngradedEmailJob::dispatch(
                $this->user,
                Arr::get($this->request, 'reason'),
                Arr::get($this->request, 'reason_custom')
            );
            $this->user->log(UserLog::TYPE_SUB_DOWNGRADE);

            return $this;
        }

        // Determine if the pledge was changed or not
        $new = ! $this->upgrading();

        // Add the necessary roles and pledge data
        $this->user->pledge = $this->tier->name;
        $this->user->update(['pledge' => $this->tier->name]);

        // We're so far, good. Let's add the user to the subscriber group
        $role = Role::where('name', '=', Pledge::ROLE)->first();
        if ($role && ! $this->user->hasRole(Pledge::ROLE)) {
            $this->user->roles()->attach($role->id);
        }

        // Anything that can fail, send to the queue
        DiscordRoleJob::dispatch($this->user)->delay(now()->addSeconds($new ? 0 : 30));
        MailSettingsChangeJob::dispatch($this->user);

        // If Stripe is confirming that a sub is renewed, we don't want to do anything more
        if ($this->renewal()) {
            return $this;
        }

        // Don't send emails when called from the webhook
        if (! $this->webhook) {
            SubscriptionCreatedEmailJob::dispatch($this->user, $this->period, $new);
            WelcomeSubscriptionEmailJob::dispatch($this->user, $this->tier);

            // Save the new sub value
            if (isset($this->tier)) {
                $this->subscriptionValue = $this->tierPrice()->cost;
            }
        }

        return $this;
    }

    /**
     * Get the status of the user's subscription
     */
    public function status(): int
    {
        if (! $this->user->subscribed('kanka')) {
            return self::STATUS_UNSUBSCRIBED;
        } elseif ($this->user->subscription('kanka')->onGracePeriod()) {
            return self::STATUS_GRACE;
        } elseif ($this->user->subscription('kanka')->canceled()) {
            return self::STATUS_CANCELLED;
        }

        return self::STATUS_SUBSCRIBED;
    }

    /**
     * Get the tier amount
     */
    public function amount(): string
    {
        $amount = $this->tierPrice()->cost;

        return number_format($amount, 2);
    }

    /**
     * Get the user's current plan
     */
    public function currentPlan(): ?TierPrice
    {
        if (! $this->user->subscribed('kanka')) {
            return null;
        }
        $price = $this->user->subscription('kanka')->stripe_price;
        /** @var TierPrice $tier */
        $tier = TierPrice::where('stripe_id', $price)->first();
        if (empty($tier)) {
            return null;
        }

        return $tier;
    }

    /**
     * Cancel the user's subscription to Kanka
     */
    public function canceled(): bool
    {
        return $this->cancelled;
    }

    /**
     * Get the subscription value
     */
    public function subscriptionValue(): int
    {
        return (int) $this->subscriptionValue;
    }

    /**
     * Determine if a user is downgrading
     */
    public function downgrading(): bool
    {
        // Elemental downgrading -> owl or wyv
        if ($this->user->isElemental() && in_array($this->tier->name, [Pledge::OWLBEAR, Pledge::WYVERN])) {
            return true;
        }

        // Wyvern downgrading to owl
        if ($this->user->isWyvern() && $this->toOwlbear()) {
            return true;
        }

        // Cancelling
        return isset($this->tier) && $this->tier->name === Pledge::KOBOLD;
    }

    /**
     * Determine if a user is upgrading their plan to a higher tier
     */
    protected function upgrading(): bool
    {
        if ($this->user->pledge == Pledge::OWLBEAR && in_array($this->tier->name, [Pledge::WYVERN, Pledge::ELEMENTAL])) {
            return true;
        }

        return (bool) ($this->user->pledge == Pledge::WYVERN && $this->tier->name == Pledge::ELEMENTAL);
    }

    /**
     * Determine if the process is renewing the user or not
     */
    protected function renewal(): bool
    {
        // If we're not in a webhook, it's not possible to be an auto-renewal
        if (! $this->webhook) {
            return false;
        }

        // Check if the user's active sub is from before the current date
        /** @var ?\Laravel\Cashier\Subscription $sub */
        $sub = \Laravel\Cashier\Subscription::where('user_id', $this->user->id)->where('stripe_status', 'active')->first();
        if ($sub === null) {
            return false;
        }

        return $sub->created_at->lessThan(Carbon::yesterday());
    }

    /**
     * If the target tier is owlbear
     */
    protected function toOwlbear(): bool
    {
        return $this->tier->name == Pledge::OWLBEAR;
    }

    /**
     * Determine if the user is only limited to paypal subscriptions
     */
    public function isLimited(): bool
    {
        $countries = ['EG'];

        return $this->user->logs()
            ->where('type_id', UserLog::TYPE_LOGIN)
            ->whereIn('country', $countries)
            ->count() > 0;
    }

    protected function isYearly(): bool
    {
        return $this->period === PricingPeriod::Yearly;
    }

    public function tierPrice(): TierPrice
    {
        if (isset($this->tierPrice)) {
            return $this->tierPrice;
        }

        return $this->tierPrice = TierPrice::where('tier_id', $this->tier->id)
            ->where('currency', $this->user->currency())
            ->where('period', $this->isYearly() ? PricingPeriod::Yearly->value : PricingPeriod::Monthly->value)
            ->first();
    }
}
