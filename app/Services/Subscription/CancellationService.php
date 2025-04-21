<?php

namespace App\Services\Subscription;

use App\Exceptions\TranslatableException;
use App\Http\Requests\SubscriptionCancel;
use App\Jobs\Emails\SubscriptionCancelEmailJob;
use App\Jobs\SubscriptionEndJob;
use App\Models\SubscriptionCancellation;
use App\Models\UserLog;
use App\Traits\UserAware;
use Carbon\Carbon;

class CancellationService
{
    use UserAware;

    protected SubscriptionCancel $request;

    protected bool $webhook = false;

    public function request(SubscriptionCancel $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function cancel(): void
    {
        if (! $this->user->subscribed('kanka')) {
            throw new TranslatableException('subscription/cancellation.errors.not_subscribed');
        }

        try {
            $this->user->subscription('kanka')->cancel();
        } catch (\Exception $e) {
            // On local machines, subs get dropped from stripe and it causes issues
            $this->user->subscription('kanka')->delete();
        }

        $this->user->log(UserLog::TYPE_SUB_CANCEL);
        if ($this->webhook) {
            return;
        }
        SubscriptionCancellation::create([
            'user_id' => $this->user->id,
            'reason' => $this->request->reason,
            'custom' => $this->request->reason_custom,
            'tier' => $this->user->pledge ?? 'Owlbear',
            'duration' => $this->user->subscription('kanka')->created_at->diffInDays(Carbon::now()),
        ]);

        // Anything that can fail, send to a queue
        SubscriptionCancelEmailJob::dispatch($this->user, $this->request->reason, $this->request->reason_custom);

        // Dispatch the job when the subscription actually ends
        SubscriptionEndJob::dispatch($this->user)
            ->delay(
                $this->user->subscription('kanka')->ends_at
            );
    }
}
