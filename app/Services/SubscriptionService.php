<?php


namespace App\Services;


use App\Http\Requests\Settings\UserSubscribeStore;
use App\Jobs\DiscordRoleJob;
use App\Jobs\Emails\SubscriptionCancelEmailJob;
use App\Jobs\Emails\SubscriptionCreatedEmailJob;
use App\Jobs\Emails\SubscriptionDowngradedEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Models\Patreon;
use App\User;
use Illuminate\Support\Arr;
use TCG\Voyager\Facades\Voyager;

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

    /** @var string monthly/yearly */
    protected $period;

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
     * @throws \Exception
     */
    public function tier(string $tier): self
    {
        $this->tier = $tier;
        if (!in_array($tier, Patreon::pledges())) {
            throw new \Exception("Unknown tier level '$tier'.");
        }
        return $this;
    }

    /**
     * @param string $period
     * @return $this
     * @throws \Exception
     */
    public function period(string $period): self
    {
        $this->period = $period;
        if (!in_array($period, ['monthly', 'yearly'])) {
            throw new \Exception("Unknown period '$period'.");
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
        $plan = null;
        if ($this->tier === Patreon::PLEDGE_OWLBEAR) {
            $plan = $this->owlbearPlanID();
        } elseif ($this->tier === Patreon::PLEDGE_ELEMENTAL) {
            $plan = $this->elementalPlanID();
        }

        // Switching to kobold?
        if (empty($plan)) {
            $this->cancel(Arr::get($request, 'reason'));
            return $this;
        }

        // Update the user's payment plan
        $paymentMethodID = Arr::get($request, 'payment_id');
        $this->user->addPaymentMethod($paymentMethodID);
        $this->user->updateDefaultPaymentMethod($paymentMethodID);

        // Subscribe
        $this->subscribe($plan, $paymentMethodID);
        return $this;
    }

    /**
     * @param $planID
     * @param $paymentID
     * @return bool
     * @throws \Laravel\Cashier\Exceptions\PaymentActionRequired
     * @throws \Laravel\Cashier\Exceptions\PaymentFailure
     * @throws \Laravel\Cashier\Exceptions\SubscriptionUpdateFailure
     */
    public function subscribe($planID, $paymentID): self
    {
        if (!$this->user->subscribed('kanka')) {
            $this->user->newSubscription('kanka', $planID)
                ->create($paymentID);
        } else {
            // If going down from elemental to owlbear, keep it as is until the current billing period
            if ($this->downgrading()) {
                $this->user->subscription('kanka')->swap($planID);
            } else {
                $this->user->subscription('kanka')->swapAndInvoice($planID);
            }
        }

        return $this;
    }

    /**
     * Setup the user's pledge, role, discord
     * @param $planID
     * @return $this
     */
    public function finish($planID): self
    {
        // If downgrading, send admins an email, and let stripe deal with the rest. A user update hook will be thrown
        // when the user really changes. Probably?
        if ($this->downgrading()) {
            SubscriptionDowngradedEmailJob::dispatch($this->user);
            return $this;
        }

        $plan = in_array($planID, $this->elementalPlans()) ? Patreon::PLEDGE_ELEMENTAL : Patreon::PLEDGE_OWLBEAR;
        $new = !($this->user->patreon_pledge == Patreon::PLEDGE_OWLBEAR && $plan == Patreon::PLEDGE_ELEMENTAL);

        // Add the necessary roles and patreon data
        $this->user->patreon_pledge = $plan;
        $this->user->update(['patreon_pledge']);

        // We're so far, good. Let's add the user to the Patreon group
        $role = Voyager::model('Role')->where('name', '=', 'patreon')->first();
        if ($role && !$this->user->hasRole('patreon')) {
            $this->user->roles()->attach($role->id);
        }

        // Anything that can fail, send to the queue
        DiscordRoleJob::dispatch($this->user);
        SubscriptionCreatedEmailJob::dispatch($this->user, $new);

        return $this;
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
        if ($this->tier === Patreon::PLEDGE_OWLBEAR) {
            $amount = 5;
        } elseif ($this->tier === Patreon::PLEDGE_ELEMENTAL) {
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
        if ($this->user->subscribedToPlan($this->elementalPlans(), 'kanka')) {
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
    public function cancel(string $reason = null): bool
    {
        $this->user->subscription('kanka')->cancel();

        // Anything that can fail, send to a queue
        SubscriptionCancelEmailJob::dispatch($this->user, $reason);

        // Dispatch the job when the subscription actually ends
        SubscriptionEndJob::dispatch($this->user)
            ->delay(
                $this->user->subscription('kanka')->ends_at
            );

        return true;
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
    public function monthlyPlans(): array
    {
        return [
            config('subscription.owlbear.eur.monthly'),
            config('subscription.owlbear.usd.monthly'),
            config('subscription.elemental.eur.monthly'),
            config('subscription.elemental.usd.monthly'),
        ];
    }

    /**
     * @return array
     */
    public function yearlyPlans(): array
    {
        return [
            config('subscription.owlbear.eur.yearly'),
            config('subscription.owlbear.usd.yearly'),
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
        return $this->user->isElementalPatreon() && $this->tier === Patreon::PLEDGE_OWLBEAR;
    }
}
