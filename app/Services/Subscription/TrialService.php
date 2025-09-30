<?php

namespace App\Services\Subscription;

use App\Enums\UserFlags;
use App\Jobs\Emails\TrialAcceptedEmailJob;
use App\Models\UserFlag;
use App\Traits\UserAware;
use Laravel\Cashier\Subscription;

class TrialService
{
    use UserAware;

    public function accept(): void
    {
        $this->removeFlag();
        $this->start();
    }

    protected function start(): void
    {
        $this->user->roles()->syncWithoutDetaching([5]);

        $this->user->pledge = 'Owlbear';
        $this->user->save();

        $sub = new Subscription;
        $sub->user_id = $this->user->id;
        $sub->type = 'kanka';
        $sub->stripe_id = 'manual_sub_' . uniqid();
        $sub->stripe_status = 'canceled';
        $sub->stripe_price = 'trial_' . $this->user->pledge;
        $sub->quantity = 1;
        $sub->ends_at = now()->addDays(16)->startOfDay();
        $sub->save();

        $flag = new UserFlag;
        $flag->user_id = $this->user->id;
        $flag->flag = UserFlags::startTrial;
        $flag->save();

        TrialAcceptedEmailJob::dispatch($this->user);
    }

    protected function removeFlag(): void
    {
        $this
            ->user
            ->flags()
            ->freeTrial()
            ->delete();
        session()->remove('kanka.freeTrial');
    }
}
