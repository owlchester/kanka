<?php

namespace App\Services\Subscription;

use App\Enums\UserAction;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Cashier\PaymentMethod;
use Stripe\Card;

class PaymentMethodService
{
    public function updateExpiry(User $user, UserAction $action)
    {
        $defaultPaymentMethod = $user->defaultPaymentMethod();
        if ($defaultPaymentMethod instanceof PaymentMethod) {
            /** @var Card $card */
            $card = $defaultPaymentMethod->asStripePaymentMethod()->card;
            $expiresAt = Carbon::createFromDate($card->exp_year, $card->exp_month)->endOfMonth();
            $user->card_expires_at = $expiresAt;
        } else {
            $user->card_expires_at = null;
        }
        $user->saveQuietly();
        $user->log($action);
    }
}
