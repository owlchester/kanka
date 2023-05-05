<?php

namespace App\Services;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{   
    /**
    * @param Request $request
    * @return mixed
    */
   public function process(Request $request)
   {
        $user = $request->user();
        if ($user->isSubscriber()) {
            return [];
        }
        
        $pledge = $request->get('tier');
        $currency = "USD";
        if ($user->billedInEur()) {
            $currency = "EUR";
        }
        if ($pledge === 'Owlbear') {
            $price = "55.00";
        } elseif ($pledge === 'Wyvern') {
            $price = "110.00";
        } elseif ($pledge === 'Elemental') {
            $price = "275.00";
        }
        
        $provider = new PayPalClient;
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
    * @param Request $request
    */
    public function subscribeUser(Request $request, string $pledge)
    {
        $user = $request->user();

        // Add the subscriber role
        $user->roles()->syncWithoutDetaching([5]);

        // Add the sub level
        $user->pledge = $pledge;
        $user->save();
        $sub = new Subscription();
        $sub->user_id = $user->id;
        $sub->name = 'kanka';
        $sub->stripe_id = 'manual_sub';
        $sub->stripe_status = 'canceled';
        $sub->stripe_price = 'paypal_' . $user->pledge;
        $sub->quantity = 1;
        $sub->ends_at = Carbon::now()->addYear();
        $sub->save();
    }
}
