<?php

namespace App\Services\Subscription;

use App\Enums\PricingPeriod;
use App\Enums\UserAction;
use App\Enums\UserFlags;
use App\Exceptions\TranslatableException;
use App\Facades\UserLogger;
use App\Jobs\Emails\Subscriptions\SubscriptionPausedEmailJob;
use App\Models\TierPrice;
use App\Models\UserFlag;
use App\Traits\UserAware;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;

class PauseService
{
    use UserAware;

    public function pausedUntil(): ?Carbon
    {
        $subscription = $this->user->subscription('kanka');
        if (! $subscription) {
            return null;
        }

        $value = $subscription->getAttribute('paused_until');
        if ($value === null) {
            return null;
        }

        return $value instanceof Carbon ? $value : Carbon::parse((string) $value);
    }

    public function isPaused(): bool
    {
        return $this->pausedUntil()?->isFuture() ?? false;
    }

    public function canPause(): bool
    {
        if (! $this->user->subscribed('kanka')) {
            return false;
        }

        if ($this->user->hasPayPal() || $this->user->hasManualSubscription() || $this->user->isLegacyPatron()) {
            return false;
        }

        $subscription = $this->user->subscription('kanka');
        if (! $subscription || $subscription->stripe_status !== 'active' || $subscription->onGracePeriod() || $this->isPaused()) {
            return false;
        }

        if ($this->minDays() > 0 && ($subscription->created_at === null || $subscription->created_at->gt(Carbon::now()->subDays($this->minDays())))) {
            return false;
        }

        $tierPrice = TierPrice::stripe($subscription->stripe_price)->first();
        if (! $tierPrice || $tierPrice->period !== PricingPeriod::Monthly) {
            return false;
        }

        return ! $this->user->flags()
            ->where('flag', UserFlags::subPaused->value)
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->exists();
    }

    /**
     * @throws TranslatableException
     */
    public function pause(int $months): Carbon
    {
        if (! in_array($months, [1, 2, 3], true) || ! $this->canPause()) {
            throw new TranslatableException('subscriptions/pause.errors.ineligible');
        }

        /** @var Subscription $subscription */
        $subscription = $this->user->subscription('kanka');

        $periodEndTs = $this->getStripePeriodEnd($subscription);
        $resumeAt = Carbon::createFromTimestamp($periodEndTs)->addMonthsNoOverflow($months)->subHour();

        $this->updateStripePauseCollection($subscription, [
            'behavior' => 'void',
            'resumes_at' => $resumeAt->timestamp,
        ]);

        $subscription->forceFill(['paused_until' => $resumeAt])->save();

        $flag = new UserFlag;
        $flag->user_id = $this->user->id;
        $flag->flag = UserFlags::subPaused;
        $flag->save();

        UserLogger::user($this->user)->log(UserAction::subPause);
        app(YearlyNudgeService::class)->user($this->user)->forgetCache();

        SubscriptionPausedEmailJob::dispatch($this->user, $resumeAt);

        return $resumeAt;
    }

    /**
     * @throws TranslatableException
     */
    public function resume(): void
    {
        if (! $this->isPaused()) {
            throw new TranslatableException('subscriptions/pause.errors.not_paused');
        }

        /** @var Subscription $subscription */
        $subscription = $this->user->subscription('kanka');

        $this->updateStripePauseCollection($subscription, '');

        $subscription->forceFill(['paused_until' => null])->save();

        UserLogger::user($this->user)->log(UserAction::subResume);
        app(YearlyNudgeService::class)->user($this->user)->forgetCache();
    }

    protected function minDays(): int
    {
        return 30;
    }

    protected function getStripePeriodEnd(Subscription $subscription): int
    {
        $stripeSub = $subscription->asStripeSubscription();

        return (int) ($stripeSub->current_period_end ?? $stripeSub->items->data[0]->current_period_end ?? Carbon::now()->timestamp);
    }

    /**
     * @param  array{behavior: string, resumes_at: int}|string  $pauseCollection
     */
    protected function updateStripePauseCollection(Subscription $subscription, array|string $pauseCollection): void
    {
        $this->user->stripe()->subscriptions->update($subscription->stripe_id, [
            'pause_collection' => $pauseCollection,
        ]);
    }
}
