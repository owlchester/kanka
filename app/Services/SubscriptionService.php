<?php


namespace App\Services;


use App\User;
use Illuminate\Support\Facades\Auth;

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

    public function subscribe(string $tier): bool
    {


        return true;
    }

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
        if ($this->user->subscribedToPlan($this->owlbearPlanID(), 'kanka')) {
            return $plans[0];
        }
        if ($this->user->subscribedToPlan($this->elementalPlanID(), 'kanka')) {
            return $plans[1];
        }

        return [];
    }

    /**
     * Cancel the user's subscription to Kanka
     * @return bool
     */
    public function cancel(): bool
    {
        $this->user->subscription('kanka')->cancel();
        return true;
    }

    /**
     * @return string
     */
    public function owlbearPlanID(): string
    {
        return 'plan_GpUqLFK2wNkwwD';
    }

    /**
     * @return string
     */
    public function elementalPlanID(): string
    {
        return 'plan_GpUs553mkmyDpA';
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
                'price' => '5 / ' . __('front.pricing.tier.month')
            ],
            [
                'key' => $this->elementalPlanID(),
                'name' => 'Elemental',
                'colour' => 'red',
                'image' => 'https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png',
                'price' => '25 / ' . __('front.pricing.tier.month')
            ]
        ];
    }
}
