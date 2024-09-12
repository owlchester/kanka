<?php

namespace App\Services;

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Traits\UserAware;
use Carbon\Carbon;

class SubscriptionUpgradeService
{
    use UserAware;

    protected Tier $tier;

    protected PricingPeriod $period;

    public function tier(Tier $tier): self
    {
        $this->tier = $tier;
        return $this;
    }

    public function period(PricingPeriod $pricingPeriod): self
    {
        $this->period = $pricingPeriod;
        return $this;
    }

    public function upgradePrice(): float|int
    {
        $monthly = true;

        $price = $this->tier->price($this->user->currency(), $this->period);

        if (!$this->user->subscribed('kanka') || $this->user->hasManualSubscription()) {
            return $price;
        }
        if ($this->user->isStripeYearly() || $this->user->hasPayPal()) {
            $monthly = false;
        }

        // Calculate the current subscription price
        $code = 'owlbear';
        if ($this->user->isElemental()) {
            $code = 'elemental';
            if (!$monthly) {
                return 0;
            }
        } elseif ($this->user->isWyvern()) {
            $code = 'wyvern';
        }
        $this->tier = Tier::where('code', $code)->first();
        $oldPrice = $this->tier->price(
            $this->user->currency(),
            $monthly ? PricingPeriod::Monthly : PricingPeriod::Yearly
        );
        $endPeriod = $this->endPeriod();
        if ($this->period === PricingPeriod::Yearly) {
            // Prorated Cost = (New Tier Cost - Old Tier Cost) x (Number of Days Remaining / Number of Days in a Full Year)
            // If going from monthly to yearly, we divide the current sub up on a month
            $duration = $monthly ? 31 : 365;
            $price = round(($price - ($oldPrice)) * ($endPeriod->diffInDays(Carbon::now(), true) / $duration), 2);

        } elseif ($monthly && $this->period === PricingPeriod::Monthly) {
            // Prorated Cost = (New Tier Cost - Old Tier Cost) x (Number of Days Remaining / Total Days in the Month)
//            dump($price);
//            dump($oldPrice);
//            dump($endPeriod->format('Y.m.d'));
//            dump($endPeriod->diffInDays(Carbon::now(), true));
//            dump($endPeriod->diffInDays(Carbon::now(), true)/ 31);
            $price = round(($price - ($oldPrice)) * ($endPeriod->diffInDays(Carbon::now(), true) / 31), 2);
        } elseif ($this->period === PricingPeriod::Monthly) {
            // Switching from a yearly plan to a monthly plan, this gets interesting
            $remaining = 365;
            $price = round(($price - ($oldPrice)) * ($endPeriod->diffInDays(Carbon::now(), true) / $remaining), 2);
        }

        return max(0, $price);
    }

    protected function endPeriod(): Carbon
    {
        // Stripe provides us with this information easily
        if (!$this->user->hasPayPal()) {
            return Carbon::createFromTimestamp($this->user->subscription('kanka')->asStripeSubscription()->current_period_end);
        }

        // For paypal, we need the subscription's end date
        return $this->user->subscription('kanka')->ends_at;
    }
}
