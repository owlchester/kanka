<?php

namespace App\Services;

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Traits\UserAware;
use Illuminate\Support\Collection;
use Laravel\Cashier\Invoice;
use Laravel\Cashier\InvoiceLineItem;

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

        return $this->stripeUpgradePrice($price);
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

        return max(0, $this->prorationAmount($invoice) / 100);
    }

    /**
     * Stripe's upcoming invoice preview also includes the next full billing cycle's
     * regular charge alongside the proration lines, since that's what the customer's
     * actual next invoice will contain. We only want the amount due for the immediate
     * change, so only sum the lines Stripe flagged as prorations.
     */
    protected function prorationAmount(Invoice $invoice): int
    {
        return Collection::make($invoice->invoiceLineItems())
            ->filter(fn (InvoiceLineItem $item) => $item->asStripeInvoiceLineItem()->proration)
            ->sum(fn (InvoiceLineItem $item) => $item->asStripeInvoiceLineItem()->amount);
    }
}
