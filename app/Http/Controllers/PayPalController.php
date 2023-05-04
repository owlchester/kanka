<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $user = $request->user();
        $pledge = $request->get('tier');
        $period = $request->get('period');
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
                "return_url" => route('success.transaction'),
                "cancel_url" => route('cancel.transaction'),
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
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        } else {
            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        //dd($request, $this->segs, $response);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $user = $request->user();
            
            // Add the subscriber role
            $user->roles()->syncWithoutDetaching([5]);

            // Add the sub level
            $user->pledge = $response['purchase_units']['0']['reference_id'];
            $user->save();
            $sub = new Subscription();
            $sub->user_id = $user->id;
            $sub->name = 'kanka';
            $sub->stripe_id = 'manual_sub';
            $sub->stripe_status = 'canceled';
            $sub->stripe_price = 'manual_' . $user->pledge;
            $sub->quantity = 1;
            $sub->ends_at = Carbon::now()->addYear();
            $sub->save();
            
            $routeOptions = ['success' => 1];

            return redirect()
                ->route('settings.subscription', $routeOptions)
                ->with('success', __('settings.subscription.success.subscribed'));
        } else {
            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('settings.subscription')
            ->with('error', __('settings.subscription.errors.callback'));
    }
}
