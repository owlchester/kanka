<?php


namespace App\Services;


use App\Http\Requests\Settings\UserSubscribeStore;
use App\Jobs\DiscordRoleJob;
use App\Jobs\Emails\SubscriptionCancelEmailJob;
use App\Jobs\Emails\SubscriptionCreatedEmailJob;
use App\Jobs\Emails\SubscriptionDowngradedEmailJob;
use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\Emails\SubscriptionNewElementalEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Models\Patreon;
use App\Models\Role;
use App\Models\SubscriptionSource;
use App\Models\UserLog;
use App\Notifications\Header;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Customer as StripeCustomer;
use Stripe\Source;
use Stripe\Stripe;
use Exception;

class SubscriptionService
{
    public const STATUS_UNSUBSCRIBED = 0;
    public const STATUS_SUBSCRIBED = 1;
    public const STATUS_GRACE = 2;
    public const STATUS_CANCELLED = 3;

    /** @var User */
    protected $user;

    /** @var string */
    protected $tier;

    /** @var string*/
    protected $plan = null;

    /** @var string monthly/yearly */
    protected $period;

    /** @var string giropay,sofort,ideal */
    protected $method;

    /** @var bool set to true if the request comes from a webhook */
    protected $webhook = false;

    /** @var bool if the user has cancelled */
    protected $cancelled = false;

    /** @var null|string applied coupon */
    protected $coupon = null;

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $tier
     * @return $this
     * @throws Exception
     */
    public function tier(string $tier): self
    {
        $this->tier = $tier;
        if (!in_array($tier, Patreon::pledges())) {
            throw new Exception("Unknown tier level '$tier'.");
        }
        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function method(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $period
     * @return $this
     * @throws Exception
     */
    public function period(string $period): self
    {
        $this->period = $period;
        if (!in_array($period, ['monthly', 'yearly'])) {
            throw new Exception("Unknown period '$period'.");
        }
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

    public function coupon($coupon): self
    {
        if ($this->period === 'yearly' && !empty($coupon)) {
            $this->coupon = $coupon;
        }
        return $this;
    }

    /**
     * Change plans
     *
     * @param array $request
     * @return $this
     */
    public function change(array $request): self
    {
        // Get the correct plan
        $this->plan = null;
        if ($this->toOwlbear()) {
            $this->plan = $this->owlbearPlanID();
        } elseif ($this->toWyvern()) {
            $this->plan = $this->wyvernPlanID();
        } elseif ($this->toElemental()) {
            $this->plan = $this->elementalPlanID();
        }

        // Switching to kobold?
        if (empty($this->plan)) {
            //Log::debug('Cancelling plan for user ' . $this->user->id);
            $this->cancel(Arr::get($request, 'reason'), Arr::get($request, 'reason_custom'));
            return $this;
        }

        // Update the user's payment plan
        $paymentMethodID = Arr::get($request, 'payment_id');
        $this->user->addPaymentMethod($paymentMethodID);
        $this->user->updateDefaultPaymentMethod($paymentMethodID);

        // Subscribe
        $this->subscribe($this->plan, $paymentMethodID);
        return $this;
    }

    /**
     * @param $planID
     * @param $paymentID
     * @return bool
     * @throws \Laravel\CashierExceptions\PaymentActionRequired
     * @throws \Laravel\CashierExceptions\PaymentFailure
     * @throws \Laravel\CashierExceptions\SubscriptionUpdateFailure
     */
    public function subscribe($planID, $paymentID): self
    {
        if (!$this->user->subscribed('kanka')) {
            $this->user->newSubscription('kanka', $planID)
                ->withCoupon($this->coupon)
                ->create($paymentID);

            UserLog::create([
                'user_id' => $this->user->id,
                'type_id' => UserLog::TYPE_SUB_NEW,
            ]);
        } else {
            // If going down from elemental to owlbear, keep it as is until the current billing period
            if ($this->downgrading()) {
                $this->user->subscription('kanka')->swap($planID);

                UserLog::create([
                    'user_id' => $this->user->id,
                    'type_id' => UserLog::TYPE_SUB_DOWNGRADE,
                ]);
            } else {
                $this->user->subscription('kanka')->swapAndInvoice($planID);

                UserLog::create([
                    'user_id' => $this->user->id,
                    'type_id' => UserLog::TYPE_SUB_UPGRADE,
                ]);
            }
        }

        return $this;
    }

    /**
     * Setup the user's pledge, role, discord
     * @param string|null $planID
     * @return $this
     */
    public function finish($planID = null): self
    {
        if (empty($planID) && !empty($this->plan)) {
            $planID = $this->plan;
        }

        // If the user is cancelling through the interface, don't do anything else
        if ($this->cancelled) {
            return $this;
        }

        // If downgrading, send admins an email, and let stripe deal with the rest. A user update hook will be thrown
        // when the user really changes. Probably?
        if ($this->downgrading()) {
            SubscriptionDowngradedEmailJob::dispatch($this->user);
            UserLog::create([
                'user_id' => $this->user->id,
                'type_id' => UserLog::TYPE_SUB_DOWNGRADE,
            ]);
            return $this;
        }

        $plan = in_array($planID, $this->elementalPlans()) ? Patreon::PLEDGE_ELEMENTAL :
            (in_array($planID, $this->wyvernPlans()) ? Patreon::PLEDGE_WYVERN : Patreon::PLEDGE_OWLBEAR);

        // Determine if the pledge was changed or not
        $new = !$this->upgrading($plan);

        // Add the necessary roles and patreon data
        $this->user->patreon_pledge = $plan;
        $this->user->update(['patreon_pledge']);

        // We're so far, good. Let's add the user to the Patreon group
        $role = Role::where('name', '=', 'patreon')->first();
        if ($role && !$this->user->hasRole('patreon')) {
            $this->user->roles()->attach($role->id);
        }

        // Anything that can fail, send to the queue
        $period = !empty($this->period) ? $this->period : (in_array($planID, $this->yearlyPlans()) ? 'yearly' : 'monthly');
        DiscordRoleJob::dispatch($this->user)->delay(now()->addSeconds($new ? 0 : 30));

        // If Stripe is confirming that a sub is renewed, we don't want to do anything more
        if ($this->renewal()) {
            return $this;
        }

        SubscriptionCreatedEmailJob::dispatch($this->user, $period, $new);
        if ($plan == Patreon::PLEDGE_ELEMENTAL) {
            SubscriptionNewElementalEmailJob::dispatch($this->user, $period, $new);
        }

        return $this;
    }

    /**
     * A payment from a credit card failed so we need to warn the user and us
     */
    public function failed()
    {
        // Notify admin
        SubscriptionFailedEmailJob::dispatch($this->user);


    }

    /**
     * @param Request $request
     * @return Source
     * @throws \StripeException\ApiErrorException
     */
    public function prepare(Request $request): Source
    {
        $amount = $this->toElemental() ? 25 : ($this->toWyvern() ? 10 : 5);
        $amount = ($amount * ($this->period === 'yearly' ? 11 : 1)) * 100;

        Stripe::setApiKey(config('cashier.secret'));
        $data = [
            'type' => $this->method,
            'amount' => $amount,
            'currency' => 'eur',
            'owner' => ['email' => $this->user->email],
            'redirect' => ['return_url' => route('settings.subscription.alt-callback')],
            'statement_descriptor' => 'Kanka ' . ucfirst($this->tier),
        ];

        if ($this->method === 'sofort') {
            $languages = ['en', 'de', 'es', 'it', 'fr', 'nl', 'pl'];
            $data['sofort'] = [
                'country' => $request->get('sofort-country'),
                'preferred_language' => in_array($this->user->locale, $languages) ? $this->user->locale : 'en',
            ];
        } elseif ($this->method === 'giropay') {
            $data['owner'] = [
                'name' => $request->get('accountholder-name')
            ];
        }

        // Create the source object
        $source = \Stripe\Source::create($data);

        // Tell stripe to attach this source to the user
        $clientSource = StripeCustomer::createSource($this->user->stripe_id, ['source' => $source->id]);

        $subSource = SubscriptionSource::create([
            'user_id' => $this->user->id,
            'source_id' => $source->id,
            'tier' => $this->tier,
            'period' => $this->period,
            'status' => 'prepare',
            'method' => $this->method,
        ]);

        //Log::info('New sub_source id: ' . $subSource->id);

        return $source;
    }

    /**
     * @return int
     */
    public function status()
    {
        if (!$this->user->subscribed('kanka')) {
            return self::STATUS_UNSUBSCRIBED;
        }
        elseif ($this->user->subscription('kanka')->onGracePeriod()) {
            return self::STATUS_GRACE;
        }
        elseif ($this->user->subscription('kanka')->cancelled()) {
            return self::STATUS_CANCELLED;
        }

        return self::STATUS_SUBSCRIBED;
    }

    /**
     * Get the tier amount
     * @return string
     */
    public function amount(): string
    {
        $amount = 0;
        if ($this->toOwlbear()) {
            $amount = 5;
        } elseif ($this->toWyvern()) {
            $amount = 10;
        } elseif ($this->toElemental()) {
            $amount = 25;
        }

        // Offer a free month for those who sub for a year
        if ($this->period === 'yearly') {
            $amount *= 11;
        }

        return $this->user->currencySymbol() . ' ' . $amount . '.00';
    }
    /**
     * Get the user's current plan
     * @return string
     */
    public function currentPlan(): string
    {
        if ($this->user->subscribedToPlan($this->owlbearPlans(), 'kanka')) {
            return Patreon::PLEDGE_OWLBEAR;
        }
        elseif ($this->user->subscribedToPlan($this->wyvernPlans(), 'kanka')) {
            return Patreon::PLEDGE_WYVERN;
        }
        elseif ($this->user->subscribedToPlan($this->elementalPlans(), 'kanka')) {
            return Patreon::PLEDGE_ELEMENTAL;
        }

        // Free user?
        return Patreon::PLEDGE_KOBOLD;
    }

    /**
     * Cancel the user's subscription to Kanka
     * @param string|null $reason
     * @return bool
     */
    public function cancel(string $reason = null, string $custom = null): bool
    {
        $this->user->subscription('kanka')->cancel();

        // Anything that can fail, send to a queue
        SubscriptionCancelEmailJob::dispatch($this->user, $reason, $custom);

        // Dispatch the job when the subscription actually ends
        SubscriptionEndJob::dispatch($this->user)
            ->delay(
                $this->user->subscription('kanka')->ends_at
            );

        // Log on the user that they cancelled
        UserLog::create([
            'user_id' => $this->user->id,
            'type_id' => UserLog::TYPE_SUB_CANCEL,
        ]);

        $this->cancelled = true;

        return true;
    }

    /**
     * @return bool
     */
    public function cancelled(): bool
    {
        return $this->cancelled;
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function sourceCharge(array $payload)
    {
        /** @var SubscriptionSource $source */
        $source = SubscriptionSource::where('source_id', Arr::get($payload, 'data.object.id'))
            ->firstOrFail();
        $this->user($source->user);

        $amount = $source->tier === Patreon::PLEDGE_ELEMENTAL ? 25 : ($source->tier === Patreon::PLEDGE_WYVERN ? 10 : 5);
        $amount = ($amount * ($source->period === 'yearly' ? 11 : 1)) * 100;

        try {
            // Charge the user
            Stripe::setApiKey(config('cashier.secret'));

            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $source->currency(),
                'source' => $source->source_id,
                'description' => 'Kanka ' . ucfirst($source->tier) . ' ' . $source->period,
                'customer' => $source->user->stripe_id,
            ]);

            $source->charge_id = $charge->id;
            $source->status = $charge->status;
            $source->save();

            // While the payment is pending, it can take up to two days for it to complete. So we'll assume that the user is properly subscribed.
            $this->user->patreon_pledge = $source->tier;
            $this->user->update(['patreon_pledge']);

            // We're so far, good. Let's add the user to the Patreon group
            $role = Role::where('name', '=', 'patreon')->first();
            if ($role && !$this->user->hasRole('patreon')) {
                $this->user->roles()->attach($role->id);
            }

            // Anything that can fail, send to the queue
            DiscordRoleJob::dispatch($this->user);
            SubscriptionCreatedEmailJob::dispatch($this->user, $source->period, true);

            // Create the fake cashier subscription
            $end = Carbon::now()->addMonth();
            if ($source->period === 'yearly') {
                $end = Carbon::now()->addYear();
            }

            \Laravel\Cashier\Subscription::create([
                'user_id' => $this->user->id,
                'name' => 'kanka',
                'stripe_id' => $source->method . '_' . $source->id,
                'stripe_status' => 'active',
                'stripe_plan' => $source->plan(),
                'quantity' => 1,
                'ends_at' => $end
            ]);


            // Notify the user in app about the change
            $this->user->notify(
                new Header(
                    'subscriptions.started',
                    'fas fa-credit-card',
                    'green'
                )
            );
        } catch(Exception $e) {

            $this->user->notify(
                new Header(
                    'subscriptions.charge_fail',
                    'fas fa-credit-card',
                    'red'
                )
            );

            throw $e;
        }

        return true;
    }

    /**
     * About 0.2% of sofort payments fail, so we need to handle them.
     * @param array $payload
     */
    public function chargeFailed(array $payload)
    {
        /** @var SubscriptionSource $source */
        $source = SubscriptionSource::where('charge_id', Arr::get($payload, 'data.object.charge'))
            ->first();
        if (empty($source)) {
            // If the source is empty, means this is a failed charge for a credit card, not a sofort payment.
            $this->failed();
            return false;
        }


        $this->user = $source->user;

        // user was deleted
        if (empty($this->user) || $this->user->id == 27078) {
            Log::info('Subscription charge failed for welterbrand');
            return true;
        }
        Log::info('Subscription charge failed (giropay/sofort)', ['user_id' => $this->user->id]);
        $source->update(['status' => 'failed']);


        // Remove all the user's stuff directly
        if ($this->user->subscribed('kanka')) {
            $this->user->subscription('kanka')->delete();
        }

        // Anything that can fail, send to a queue
        SubscriptionCancelEmailJob::dispatch($this->user, $source->method . ' charge failed');

        // Dispatch the job when the subscription actually ends
        SubscriptionEndJob::dispatch($this->user);

        // Log info on the user
        UserLog::create([
            'user_id' => $this->user->id,
            'type_id' => UserLog::TYPE_SUB_FAIL,
        ]);

        return true;
    }

    /**
     * Validate the stripe source
     * @param string $secret
     * @return bool
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function validSource(string $secret): bool
    {
        Stripe::setApiKey(config('cashier.secret'));

        $source = Source::retrieve($secret);

        return $source->status != 'failed';
    }

    /**
     * @return string
     */
    public function owlbearPlanID(): string
    {
        return $this->user->currency === 'eur' ?
            config('subscription.owlbear.eur.' . $this->period) :
            config('subscription.owlbear.usd.' . $this->period);
    }

    /**
     * @return string
     */
    public function wyvernPlanID(): string
    {
        return $this->user->currency === 'eur' ?
            config('subscription.wyvern.eur.' . $this->period) :
            config('subscription.wyvern.usd.' . $this->period);
    }

    /**
     * @return string
     */
    public function elementalPlanID(): string
    {
        return $this->user->currency === 'eur' ?
            config('subscription.elemental.eur.' . $this->period) :
            config('subscription.elemental.usd.' . $this->period);
    }

    /**
     * @return array
     */
    public function owlbearPlans(): array
    {
        // eur: plan_GpVbGxVYKmmnp8 usd: plan_GpVZhf8C9bMAt4
        return [
            config('subscription.owlbear.eur.monthly'),
            config('subscription.owlbear.usd.monthly'),
            config('subscription.owlbear.eur.yearly'),
            config('subscription.owlbear.usd.yearly'),
        ];
    }

    /**
     * @return array
     */
    public function wyvernPlans(): array
    {
        // eur: plan_GpVbGxVYKmmnp8 usd: plan_GpVZhf8C9bMAt4
        return [
            config('subscription.wyvern.eur.monthly'),
            config('subscription.wyvern.usd.monthly'),
            config('subscription.wyvern.eur.yearly'),
            config('subscription.wyvern.usd.yearly'),
        ];
    }

    /**
     * @param string $tier = null
     * @return array
     */
    public function monthlyPlans(string $tier = null): array
    {
        if (!empty($tier)) {
            return [
                config('subscription.' . strtolower($tier). '.eur.monthly'),
                config('subscription.' . strtolower($tier). '.usd.monthly'),
            ];
        }
        return [
            config('subscription.owlbear.eur.monthly'),
            config('subscription.owlbear.usd.monthly'),
            config('subscription.wyvern.eur.monthly'),
            config('subscription.wyvern.usd.monthly'),
            config('subscription.elemental.eur.monthly'),
            config('subscription.elemental.usd.monthly'),
        ];
    }

    /**
     * @param string $tier = null
     * @return array
     */
    public function yearlyPlans(string $tier = null): array
    {
        if (!empty($only)) {
            return [
                config('subscription.' . strtolower($tier). '.eur.yearly'),
                config('subscription.' . strtolower($tier). '.usd.yearly'),
            ];
        }
        return [
            config('subscription.owlbear.eur.yearly'),
            config('subscription.owlbear.usd.yearly'),
            config('subscription.wyvern.eur.yearly'),
            config('subscription.wyvern.usd.yearly'),
            config('subscription.elemental.eur.yearly'),
            config('subscription.elemental.usd.yearly'),
        ];
    }

    /**
     * @return array
     */
    public function elementalPlans(): array
    {
        // eur: plan_GpYTOMLzQzBo6K usd: plan_GpYTfsbyHMlUEk
        return [
            config('subscription.elemental.eur.monthly'),
            config('subscription.elemental.eur.yearly'),
            config('subscription.elemental.usd.monthly'),
            config('subscription.elemental.usd.yearly')
        ];
    }

    /**
     * Determine if a user is downgrading
     * @return bool
     */
    protected function downgrading(): bool
    {
        // Elemental downgrading -> owl or wyv
        if ($this->user->isElementalPatreon() && in_array($this->tier, [Patreon::PLEDGE_OWLBEAR, Patreon::PLEDGE_WYVERN])) {
            return true;
        }

        // Wyvern downgrading to owl
        if ($this->user->isWyvern() && $this->toOwlbear()) {
            return true;
        }

        // Cancelling
        return $this->tier === Patreon::PLEDGE_KOBOLD;
    }

    /**
     * Determine if a user is upgrading their plan to a higher tier
     * @param $plan
     * @return bool
     */
    protected function upgrading($plan): bool
    {
        if ($this->user->patreon_pledge == Patreon::PLEDGE_OWLBEAR && in_array($plan, [Patreon::PLEDGE_WYVERN, Patreon::PLEDGE_ELEMENTAL])) {
            return true;
        } elseif ($this->user->patreon_pledge == Patreon::PLEDGE_WYVERN && $plan == Patreon::PLEDGE_ELEMENTAL) {
            return true;
        }
        return false;
    }

    /**
     * Determine if the process is renewing the user or not
     * @return bool
     */
    protected function renewal(): bool
    {
        // If we're not in a webhook, it's not possible to be an auto-renewal
        if (!$this->webhook) {
            return false;
        }

        // Check if the user's active sub is from before the current date
        /** @var \Laravel\Cashier\Subscription $sub */
        $sub = \Laravel\Cashier\Subscription::where('user_id', $this->user->id)->where('stripe_status', 'active')->first();
        if (empty($sub)) {
            return false;
        }
        return $sub->created_at->lessThan(Carbon::yesterday());
    }

    /**
     * @return bool
     */
    protected function toOwlbear(): bool
    {
        return $this->tier == Patreon::PLEDGE_OWLBEAR;
    }

    /**
     * @return bool
     */
    protected function toWyvern(): bool
    {
        return $this->tier == Patreon::PLEDGE_WYVERN;
    }

    /**
     * @return bool
     */
    protected function toElemental(): bool
    {
        return $this->tier == Patreon::PLEDGE_ELEMENTAL;
    }
}
