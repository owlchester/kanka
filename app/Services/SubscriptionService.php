<?php


namespace App\Services;


use App\Jobs\DiscordRoleJob;
use App\Jobs\SubscriptionEndJob;
use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Mail\Subscription\Admin\NewSubscriptionMail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use TCG\Voyager\Facades\Voyager;

class SubscriptionService
{
    public const STATUS_UNSUBSCRIBED = 0;
    public const STATUS_SUBSCRIBED = 1;
    public const STATUS_GRACE = 2;
    public const STATUS_CANCELLED = 3;

    /** @var User */
    protected $user;

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
     * @param $planID
     * @param $paymentID
     * @return bool
     * @throws \Laravel\Cashier\Exceptions\PaymentActionRequired
     * @throws \Laravel\Cashier\Exceptions\PaymentFailure
     * @throws \Laravel\Cashier\Exceptions\SubscriptionUpdateFailure
     */
    public function subscribe($planID, $paymentID): bool
    {
        $new = true;
        if (!$this->user->subscribed('kanka')) {
            $this->user->newSubscription('kanka', $planID)
                ->create($paymentID);
        } else {
            $this->user->subscription('kanka')->swap($planID);
            $new = false;
        }

        // Add the necessary roles and patreon data
        $plan = in_array($planID, $this->elementalPlans()) ? 'Elemental' : 'Owlbear';
        $this->user->patreon_pledge = $plan;
        $this->user->update(['patreon_pledge']);

        // We're so far, good. Let's add the user to the Patreon group
        $role = Voyager::model('Role')->where('name', '=', 'patreon')->first();
        if ($role && !$this->user->hasRole('patreon')) {
            $this->user->roles()->attach($role->id);
        }

        DiscordRoleJob::dispatch($this->user);


        // Notify owner
        Mail::to('no-reply@kanka.io')
            ->send(
                new NewSubscriptionMail($this->user, $new)
            );

        return true;
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

        SubscriptionEndJob::dispatch($this->user, $reason);

        return true;
    }

    /**
     * @return string
     */
    public function owlbearPlanID(): string
    {
        return $this->user->currency === 'eur' ? 'plan_GpUrfPuJGBQGbx' : 'plan_GpUqLFK2wNkwwD';
    }

    /**
     * @return string
     */
    public function elementalPlanID(): string
    {
        return $this->user->currency === 'eur' ? 'plan_GpUtSHiFLIlQbt' : 'plan_GpUs553mkmyDpA';
    }

    /**
     * @return array
     */
    public function owlbearPlans(): array
    {
        return ['plan_GpUrfPuJGBQGbx', 'plan_GpUqLFK2wNkwwD'];
    }

    /**
     * @return array
     */
    public function elementalPlans(): array
    {
        return ['plan_GpUrfPuJGBQGbx', 'plan_GpUs553mkmyDpA'];
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
