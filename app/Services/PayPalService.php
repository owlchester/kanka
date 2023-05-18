<?php

namespace App\Services;

use App\Traits\UserAware;
use Laravel\Cashier\Subscription;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal;

class PayPalService
{
    use UserAware;

    /**
     * @param string $pledge
     * @return mixed
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
        if ($pledge === 'Owlbear') {
            $price = "55.00";
        } elseif ($pledge === 'Wyvern') {
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
        if (auth()->user()->id === 1) {
            dd($response);
        }

        return $response;
    }

    /**
     * @param string $pledge
     */
    public function subscribe(string $pledge): void
    {
        // Add the subscriber role
        $this->user->roles()->syncWithoutDetaching([5]);

        // Add the subscription to the user level
        $this->user->pledge = $pledge;
        $this->user->save();

        $sub = new Subscription();
        $sub->user_id = $this->user->id;
        $sub->name = 'kanka';
        $sub->stripe_id = 'manual_sub';
        $sub->stripe_status = 'canceled';
        $sub->stripe_price = 'paypal_' . $this->user->pledge;
        $sub->quantity = 1;
        $sub->ends_at = Carbon::now()->addYear();
        $sub->save();
    }
}
