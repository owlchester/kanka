<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateCoupon;
use App\Models\Tier;
use App\Models\User;
use App\Services\Subscription\CouponService;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Cashier\PaymentMethod;
use Stripe\Card;

class SubscriptionApiController extends Controller
{
    protected SubscriptionService $service;

    protected CouponService $couponService;

    /**
     * SubscriptionApiController constructor.
     */
    public function __construct(SubscriptionService $service, CouponService $couponService)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $service;
        $this->couponService = $couponService;
    }

    /**
     * Creates an intent for payment so we can capture the payment
     * method for the user.
     *
     * @param  Request  $request  The request data from the user.
     */
    public function setupIntent(Request $request)
    {
        return $request->user()->createSetupIntent();
    }

    /**
     * Adds a payment method to the current user.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Laravel\Cashier\Exceptions\CustomerAlreadyCreated
     */
    public function paymentMethods(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $paymentMethodID = $request->get('payment_method');

        if ($user->stripe_id == null) {
            $user->createAsStripeCustomer();
        }

        if ($user->isFrauding()) {
            return response()
                ->json(null, 429);
        }

        $user->addPaymentMethod($paymentMethodID);
        $user->updateDefaultPaymentMethod($paymentMethodID);

        // Save the expiration date on the user for alerts about expiring cards
        $payment = $user->defaultPaymentMethod();
        if ($payment && $payment instanceof PaymentMethod) {
            /** @var Card $card */
            $card = $payment->asStripePaymentMethod()->card;
            $expiresAt = Carbon::createFromDate($card->exp_year, $card->exp_month)->endOfMonth();
            $user->card_expires_at = $expiresAt;
            $user->save();
        }

        return response()->json(null, 204);
    }

    /**
     * Returns the payment methods the user has saved
     *
     * @param  Request  $request  The request data from the user.
     */
    public function getPaymentMethods(Request $request)
    {
        $user = $request->user();

        $methods = [];

        if ($user->hasPaymentMethod()) {
            foreach ($user->paymentMethods() as $method) {
                array_push($methods, [
                    'id' => $method->id, // @phpstan-ignore-line
                    'brand' => $method->card->brand, // @phpstan-ignore-line
                    'last_four' => $method->card->last4, // @phpstan-ignore-line
                    'exp_month' => $method->card->exp_month, // @phpstan-ignore-line
                    'exp_year' => $method->card->exp_year, // @phpstan-ignore-line
                ]);
            }
        }

        return response()->json($methods);
    }

    /**
     * Removes a payment method for the current user.
     *
     * @param  Request  $request  The request data from the user.
     */
    public function removePaymentMethod(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $paymentMethodID = $request->get('id');

        $paymentMethods = $user->paymentMethods();

        foreach ($paymentMethods as $method) {
            // @phpstan-ignore-next-line
            if ($method->id == $paymentMethodID) {
                $method->delete();
                break;
            }
        }

        $user->card_expires_at = null;
        $user->saveQuietly();

        return response()->json(null, 204);
    }

    public function checkCoupon(ValidateCoupon $request, Tier $tier)
    {
        /** @var User $user */
        $user = $request->user();
        $coupon = $request->get('coupon');

        return response()->json(
            $this->couponService
                ->user($user)
                ->code((string) $coupon)
                ->tier($tier)
                ->check()
        );
    }
}
