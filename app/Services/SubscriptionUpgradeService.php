<?php

namespace App\Services;

use App\Traits\UserAware;
use Carbon\Carbon;

class SubscriptionUpgradeService
{
    use UserAware;

    public function upgradePrice(string $period, string $tier): string
    {
        $plans = [
            config('subscription.owlbear.eur.yearly'),
            config('subscription.owlbear.usd.yearly'),
            config('subscription.wyvern.eur.yearly'),
            config('subscription.wyvern.usd.yearly'),
            config('subscription.elemental.eur.yearly'),
            config('subscription.elemental.usd.yearly'),
        ];

        $oldPrice = '';
        $currency = "US$ ";
        $monthly = true;
        if ($this->user->billedInEur()) {
            $currency = "€ ";
        }

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
        }

        if (!$this->user->isSubscriber()) {
            return $price;
        }
        // @phpstan-ignore-next-line
        if (in_array($this->user->subscriptions->first()->stripe_price, $plans) || $this->user->hasPayPal()) {
            $monthly = false;
        }
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
        if ($period == 'yearly') {
            // @phpstan-ignore-next-line
            $price = floatval($price) - ($oldPrice + ((floatval($price) / 365) * $this->user->subscriptions()->first()->updated_at->diffInDays(Carbon::now())));
        } elseif ($monthly && $period == 'monthly') {
            // @phpstan-ignore-next-line
            $price = floatval($price) - ($oldPrice + ((floatval($price) / 31) * $this->user->subscriptions()->first()->updated_at->diffInDays(Carbon::now())));
        }

        // @phpstan-ignore-next-line
        $price = $currency . str(ceil($price)) . '.00';
        

        return $price;
    }
}
