<?php

namespace App\Services\Account;

use App\Jobs\Users\DeleteUser;
use App\Models\User;
use App\Traits\UserAware;

class DeletionService
{
    use UserAware;

    public function delete(): bool
    {
        $this->subscription();
        DeleteUser::dispatch($this->user);

        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // We also need to flush the session (campaign_id and other things) since this could cause
        // weird behaviour if the user registers a new account.
        request()->session()->flush();

        return true;
    }

    /**
     * Remove the user from stripe
     */
    protected function subscription(): void
    {
        if (! $this->user->hasStripeId()) {
            return;
        }

        // If the user has no active or invalid payment
        $sub = $this->user->subscription('kanka');
        if (empty($sub) || $sub->canceled()) {
            return;
        }

        // If their sub was failing
        if ($sub->hasIncompletePayment()) {
            $sub->cancel();
        }
    }
}
