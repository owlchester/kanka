<?php

namespace App\Services\Account;

use App\Traits\UserAware;

class DeletionService
{
    use UserAware;

    public function delete(): bool
    {
        $this->subscription();
        $this->user->delete();
        return true;
    }

    /**
     * Remove the user from stripe
     * @return void
     */
    protected function subscription(): void
    {
        if (!$this->user->hasStripeId()) {
            return;
        }

        // If the user has no active or invalid payment
        $sub = $this->user->subscription('kanka');
        if (empty($sub) || $sub->cancelled()) {
            return;
        }

        // If their sub was failing
        if ($sub->hasIncompletePayment()) {
            $sub->cancel();
        }
    }
}
