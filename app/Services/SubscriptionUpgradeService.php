<?php

namespace App\Services;

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
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
        $price = $this->tier->price($this->user->currency(), $this->period);

        if (! $this->user->subscribed('kanka') || $this->user->hasManualSubscription()) {
            return $price;
        }

        // Stripe: ask Stripe directly for the prorated amount
        if (! $this->user->hasPayPal()) {
            return $this->stripeUpgradePrice($price);
        }

        // PayPal: manual proration since we can't call Stripe's API
        $monthly = ! $this->onYearlyPlan();

        $code = 'owlbear';
        if ($this->user->isElemental()) {
            $code = 'elemental';
            if (! $monthly) {
                return 0;
            }
        } elseif ($this->user->isWyvern()) {
            $code = 'wyvern';
        }
        $currentTier = Tier::where('code', $code)->first();
        $oldPrice = $currentTier->price(
            $this->user->currency(),
            $monthly ? PricingPeriod::Monthly : PricingPeriod::Yearly
        );
        $endPeriod = $this->endPeriod();

        if ($this->period === PricingPeriod::Yearly) {
            $duration = $monthly ? 31 : 365;
            $price = round(($price - $oldPrice) * ($endPeriod->diffInDays(Carbon::now(), true) / $duration), 2);
        } elseif ($monthly && $this->period === PricingPeriod::Monthly) {
            $price = round(($price - $oldPrice) * ($endPeriod->diffInDays(Carbon::now(), true) / 31), 2);
        } elseif ($this->period === PricingPeriod::Monthly) {
            $price = round(($price - $oldPrice) * ($endPeriod->diffInDays(Carbon::now(), true) / 365), 2);
        }

        return max(0, $price);
    }

    protected function stripeUpgradePrice(float $fullPrice): float
    {
        /** @var ?TierPrice $tierPrice */
        $tierPrice = TierPrice::where('tier_id', $this->tier->id)
            ->where('currency', $this->user->currency())
            ->where('period', $this->period)
            ->first();

        if (empty($tierPrice)) {
            return $fullPrice;
        }

        $invoice = $this->user->subscription('kanka')->previewInvoice($tierPrice->stripe_id);

        return max(0, $invoice->rawTotal() / 100);
    }

    protected function endPeriod(): Carbon
    {
        if (! $this->user->hasPayPal()) {
            return Carbon::createFromTimestamp($this->user->subscription('kanka')->asStripeSubscription()->current_period_end);
        }

        return $this->user->subscription('kanka')->ends_at;
    }

    protected function onYearlyPlan(): bool
    {
        if ($this->user->hasPayPal()) {
            return true;
        }

        $prices = array_merge(
            config('subscription.owlbear.yearly'),
            config('subscription.wyvern.yearly'),
            config('subscription.elemental.yearly'),
        );

        return $this->user->subscribedToPrice($prices, 'kanka');
    }
}
