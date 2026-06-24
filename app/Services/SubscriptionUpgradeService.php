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

        // Paypal: no longer allow this system
        return 1;
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
