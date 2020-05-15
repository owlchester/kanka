<?php


namespace App\Http\Controllers\Settings;

use App\Services\SubscriptionService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionApiController extends Controller
{
    /** @var SubscriptionService */
    protected $service;

    public function __construct(SubscriptionService $service)
    {
        $this->middleware(['auth', 'identity', 'shadow']);
        $this->service = $service;
    }

    /**
     * Creates an intent for payment so we can capture the payment
     * method for the user.
     *
     * @param Request $request The request data from the user.
     */
    public function setupIntent(Request $request)
    {
        return $request->user()->createSetupIntent();
    }

    /**
     * Adds a payment method to the current user.
     *
     * @param Request $request The request data from the user.
     */
    public function paymentMethods(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $paymentMethodID = $request->get('payment_method');

        if ($user->stripe_id == null) {
            $user->createAsStripeCustomer();
        }

        $user->addPaymentMethod($paymentMethodID);
        $user->updateDefaultPaymentMethod($paymentMethodID);

        return response()->json(null, 204);
    }

    /**
     * Returns the payment methods the user has saved
     *
     * @param Request $request The request data from the user.
     */
    public function getPaymentMethods( Request $request )
    {
        $user = $request->user();

        $methods = array();

        if ($user->hasPaymentMethod()) {
            foreach ($user->paymentMethods() as $method) {
                array_push($methods, [
                    'id' => $method->id,
                    'brand' => $method->card->brand,
                    'last_four' => $method->card->last4,
                    'exp_month' => $method->card->exp_month,
                    'exp_year' => $method->card->exp_year,
                ]);
            }
        }

        return response()->json($methods);
    }

    /**
     * Removes a payment method for the current user.
     *
     * @param Request $request The request data from the user.
     */
    public function removePaymentMethod( Request $request )
    {
        $user = $request->user();
        $paymentMethodID = $request->get('id');

        $paymentMethods = $user->paymentMethods();

        foreach ($paymentMethods as $method) {
            if ($method->id == $paymentMethodID) {
                $method->delete();
                break;
            }
        }

        return response()->json(null, 204);
    }
}
