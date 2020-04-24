<?php


namespace App\Services;


use App\Http\Requests\Settings\UserSubscribeStore;
use App\Jobs\DiscordRoleJob;
use App\Jobs\Emails\SubscriptionCancelEmailJob;
use App\Jobs\Emails\SubscriptionCreatedEmailJob;
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
            $this->user->subscription('kanka')->swapAndInvoice($planID);
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
        $plan = in_array($planID, $this->elementalPlans()) ? Patreon::PLEDGE_ELEMENTAL : Patreon::PLEDGE_OWLBEAR;
        $new = $this->user->patreon_pledge == Patreon::PLEDGE_OWLBEAR && $plan == Patreon::PLEDGE_ELEMENTAL;

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

        return $this->user->currencySymbol() . ' ' . $amount . '.00';
    }
    /**
     * Get the user's current plan
     * @return array
     */
    public function currentPlan(): array
    {
        $plans = $this->plans();
        if ($this->user->subscribedToPlan($this->owlbearPlans(), 'kanka')) {
            return $plans[0];
        }
        if ($this->user->subscribedToPlan($this->elementalPlans(), 'kanka')) {
            return $plans[1];
        }

        // Free user?
        return [
            'name' => 'Kobold',
            'price' => 'Free'
        ];
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
        return $this->user->currency === 'eur' ? env('STRIPE_OWLBEAR_EUR') : env('STRIPE_OWLBEAR_USD');
    }

    /**
     * @return string
     */
    public function elementalPlanID(): string
    {
        return $this->user->currency === 'eur' ? env('STRIPE_ELEMENTAL_EUR') : env('STRIPE_ELEMENTAL_USD');
    }

    /**
     * @return array
     */
    public function owlbearPlans(): array
    {
        // eur: plan_GpVbGxVYKmmnp8 usd: plan_GpVZhf8C9bMAt4
        return [env('STRIPE_OWLBEAR_EUR'), env('STRIPE_OWLBEAR_USD')];
    }

    /**
     * @return array
     */
    public function elementalPlans(): array
    {
        // eur: plan_GpYTOMLzQzBo6K usd: plan_GpYTfsbyHMlUEk
        return [env('STRIPE_ELEMENTAL_EUR'), env('STRIPE_ELEMENTAL_USD')];
    }

    /**
     * The available plans
     * @return array
     */
    public function plans(): array
    {
        return [
            [
                'key' => $this->owlbearPlanID(),
                'name' => 'Owlbear',
                'colour' => 'green',
                'image' => 'https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png',
                'price' => '5 / ' . __('front.pricing.tier.month'),
                'benefits' => [
                    __('front.features.patreon.upload_limit') => "8 mb",
                    __('front.features.patreon.upload_limit_map') => "10 mb",
                    __('front.features.patreon.discord') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.default_image')  => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.hall_of_fame', ['link' => link_to_route('front.about', __('teams.hall_of_fame'), ['#patreon'])]) => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.api_calls')  => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.pagination')  => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.monthly_vote')  => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.boosts')  => "3",
                ],
            ],
            [
                'key' => $this->elementalPlanID(),
                'name' => 'Elemental',
                'colour' => 'red',
                'image' => 'https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png',
                'price' => '25 / ' . __('front.pricing.tier.month'),
                'benefits' => [
                    __('front.features.patreon.upload_limit') => '25 mb',
                    __('front.features.patreon.upload_limit_map') => '25 mb',
                    __('front.features.patreon.discord') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.default_image') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.hall_of_fame', ['link' => link_to_route('front.about', __('teams.hall_of_fame'), ['#patreon'])]) => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.api_calls') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.pagination') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.monthly_vote') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.boosts') => '10',
                    __('front.features.patreon.curation') => '<i class="fa fa-check-circle"></i>',
                    __('front.features.patreon.impact') => '<i class="fa fa-check-circle"></i>',

                ],
            ]
        ];
    }
}
