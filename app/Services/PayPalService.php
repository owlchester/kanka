<?php

namespace App\Services;

use App\Traits\UserAware;
use Laravel\Cashier\Subscription;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal;
use App\Models\UserLog;

class PayPalService
{
    use UserAware;

    /**
     */
    public function process(string $pledge): mixed
    {
        if ($this->user->isSubscriber()) {
            return [];
        }

        $currency = "USD";
        if ($this->user->billedInEur()) {
            $currency = "EUR";
        }
        $price = "55.00";
        if ($pledge === 'Wyvern') {
            $price = "110.00";
        } elseif ($pledge === 'Elemental') {
            $price = "275.00";
        }

        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.transaction-success'),
                "cancel_url" => route('paypal.cancel-transaction'),
            ],
            "purchase_units" => [
                0 => [
                    "reference_id" => $pledge,
                    "amount" => [
                        "currency_code" => $currency,
                        "value" => $price
                    ],
                ]
            ]
        ]);

        return $response;
    }

    /**
     */
    public function subscribe(string $pledge): void
    {
        // Add the subscriber role
        $this->user->roles()->syncWithoutDetaching([5]);

        // Add the subscription to the user level
        $this->user->pledge = $pledge;
        $this->user->save();

        $sub = new Subscription();
        $sub->user_id = $this->user->id; // @phpstan-ignore-line
        $sub->name = 'kanka'; // @phpstan-ignore-line
        $sub->stripe_id = 'manual_sub'; // @phpstan-ignore-line
        $sub->stripe_status = 'canceled'; // @phpstan-ignore-line
        $sub->stripe_price = 'paypal_' . $this->user->pledge; // @phpstan-ignore-line
        $sub->quantity = 1; // @phpstan-ignore-line
        $sub->ends_at = Carbon::now()->addYear(); // @phpstan-ignore-line
        $sub->save();

        $this->user->log(UserLog::TYPE_SUB_PAYPAL);
    }
}
