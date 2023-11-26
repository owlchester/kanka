<?php

namespace App\Services;

use App\Traits\UserAware;
use Carbon\Carbon;

class SubscriptionUpgradeService
{
    use UserAware;

    public function upgradePrice(string $period, string $tier): string
    {
        $oldPrice = '';
        $monthly = true;

        $price = "55.00";
        if ($tier === 'Wyvern') {
            $price = "110.00";
            if ($period == 'monthly') {
                $price = "10.00";
            }
        } elseif ($tier === 'Elemental') {
            $price = "275.00";
            if ($period == 'monthly') {
                $price = "25.00";
            }
        } elseif ($tier === 'Owlbear') {
            $price = "55.00";
            if ($period == 'monthly') {
                $price = "5.00";
            }
        }

        if (!$this->user->subscribed('kanka')) {
            return $price;
        }
        if ($this->user->isStripeYearly() || $this->user->hasPayPal()) {
            $monthly = false;
        }

        // Calculate the current subscription price
        if ($this->user->isElemental()) {
            if ($monthly) {
                $oldPrice = "25.00";
            } else {
                return '';
            }
        } elseif ($this->user->isOwlbear()) {
            if ($monthly) {
                $oldPrice = "5.00";
            } else {
                $oldPrice = "55.00";
            }
        } elseif ($this->user->isWyvern()) {
            if ($monthly) {
                $oldPrice = "10.00";
            } else {
                $oldPrice = "110.00";
            }
        }
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
        return $this->user->subscription('kanka')->ends_at;
    }
}
