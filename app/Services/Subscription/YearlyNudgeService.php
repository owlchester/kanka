<?php

namespace App\Services\Subscription;

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Traits\UserAware;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class YearlyNudgeService
{
    use UserAware;

    /**
     * @return ?array{tier: Tier, current: TierPrice, yearly: TierPrice, savings: float, currency_symbol: string}
     */
    public function offer(): ?array
    {
        if (! $this->user->subscribed('kanka')) {
            return null;
        }

        if ($this->user->hasPayPal() || $this->user->hasManualSubscription() || $this->user->isLegacyPatron()) {
            return null;
        }

        $subscription = $this->user->subscription('kanka');
        if (! $subscription || $subscription->stripe_status !== 'active' || $subscription->onGracePeriod()) {
            return null;
        }

        $pausedUntil = $subscription->getAttribute('paused_until');
        if ($pausedUntil !== null && Carbon::parse((string) $pausedUntil)->isFuture()) {
            return null;
        }

        if ($this->minDays() > 0 && ($subscription->created_at === null || $subscription->created_at->gt(Carbon::now()->subDays($this->minDays())))) {
            return null;
        }

        /** @var ?TierPrice $current */
        $current = TierPrice::with('tier')->stripe($subscription->stripe_price)->first();
        if (! $current || $current->period !== PricingPeriod::Monthly) {
            return null;
        }

        /** @var ?TierPrice $yearly */
        $yearly = TierPrice::active()
            ->where('tier_id', $current->tier_id)
            ->where('currency', $current->currency)
            ->where('period', PricingPeriod::Yearly->value)
            ->first();

        if (! $yearly) {
            return null;
        }

        $savings = round(($current->cost * 12) - $yearly->cost, 2);
        if ($savings <= 0) {
            return null;
        }

        return [
            'tier' => $current->tier,
            'current' => $current,
            'yearly' => $yearly,
            'savings' => $savings,
            'currency_symbol' => $this->user->currencySymbol(),
        ];
    }

    /**
     * @return ?array{tier_name: string, savings: float, currency_symbol: string}
     */
    public function cachedOffer(): ?array
    {
        $cached = Cache::remember(
            $this->cacheKey(),
            now()->addHours(6),
            function (): array|false {
                $offer = $this->offer();
                if ($offer === null) {
                    return false;
                }

                return [
                    'tier_name' => $offer['tier']->name,
                    'savings' => $offer['savings'],
                    'currency_symbol' => $offer['currency_symbol'],
                ];
            }
        );

        return $cached === false ? null : $cached;
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }

    protected function minDays(): int
    {
        return (app()->isProduction() || app()->runningUnitTests()) ? 60 : 0;
    }

    protected function cacheKey(): string
    {
        return "user:{$this->user->id}:yearly_nudge";
    }
}
