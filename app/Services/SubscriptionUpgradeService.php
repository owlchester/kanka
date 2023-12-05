<?php

namespace App\Services;

use App\Models\Tier;
use App\Traits\UserAware;
use Carbon\Carbon;

class SubscriptionUpgradeService
{
    use UserAware;

    protected Tier $tier;

    public function tier(Tier $tier): self
    {
        $this->tier = $tier;
        return $this;
    }

    public function upgradePrice(string $period): string
    {
        $monthly = true;

        $price = $period == 'monthly' ? $this->tier->monthly : $this->tier->yearly;

        if (!$this->user->subscribed('kanka')) {
            return (string) $price;
        }
        if ($this->user->isStripeYearly() || $this->user->hasPayPal()) {
            $monthly = false;
        }

        // Calculate the current subscription price
        $code = 'owlbear';
        if ($this->user->isElemental()) {
            $code = 'elemental';
            if (!$monthly) {
                return '';
            }
        } elseif ($this->user->isWyvern()) {
            $code = 'wyvern';
        }
        $this->tier = Tier::where('code', $code)->first();
        $oldPrice = $monthly ? $this->tier->monthly : $this->tier->yearly;
        $endPeriod = $this->endPeriod();
        if ($period == 'yearly') {
            // Prorated Cost = (New Tier Cost - Old Tier Cost) x (Number of Days Remaining / Number of Days in a Full Year)
            $price = round((floatval($price) - ($oldPrice)) * ($endPeriod->diffInDays(Carbon::now()) / 365), 2);
        } elseif ($monthly && $period == 'monthly') {
            // Prorated Cost = (New Tier Cost - Old Tier Cost) x (Number of Days Remaining / Total Days in the Month)
            $price = round((floatval($price) - ($oldPrice)) * ($endPeriod->diffInDays(Carbon::now()) / 31), 2);
        } elseif ($period === 'monthly') {
            // Switching from a yearly plan to a monthly plan, this gets interesting
            $remaining = 365;
            $price = round((floatval($price) - ($oldPrice)) * ($endPeriod->diffInDays(Carbon::now()) / $remaining), 2);
        }


        $price = number_format(max(0, $price), 2);
        return $price;
    }

    protected function endPeriod(): Carbon
    {
        // Stripe provides us with this information easily
        if (!$this->user->hasPayPal()) {
            return Carbon::createFromTimestamp($this->user->subscription('kanka')->asStripeSubscription()->current_period_end);
        }

        // For paypal, we need the subscription's end date
        // @phpstan-ignore-next-line
        return $this->user->subscription('kanka')->ends_at;
    }
}
