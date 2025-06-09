<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Facades\DataLayer;
use App\Http\Controllers\Controller;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class FinishController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $stripeApiToken = config('cashier.key', null);
        $status = $this->subscriptionService->user($user)->status();
        $current = $this->subscriptionService->currentPlan();
        $currency = $user->currencySymbol();

        $tracking = session()->get('sub_tracking');
        $newSubPricingId = session()->get('sub_id');
        $isPayPal = $user->hasPayPal();
        $gaTrackingEvent = $gaPurchase = null;
        if (! empty($tracking)) {
            $gaTrackingEvent = 'TJhYCMDErpYDEOaOq7oC';
            DataLayer::newSubscriber();
            DataLayer::add('userSubValue', session('sub_value'));
        }

        if (! empty($newSubPricingId)) {
            /** @var TierPrice $pricing */
            $pricing = TierPrice::find($newSubPricingId);
            $gaPurchase = [
                'value' => $pricing->cost,
                'currency' => $pricing->currency,
                'coupon' => session()->get('sub_coupon'),
                'item_id' => $pricing->tier->id,
                'item_name' => $pricing->tier->name . ($pricing->isYearly() ? ' Yearly' : null),
            ];
        }

        $availableCampaigns = $user->campaigns()->unboosted()->get();
        $isTrial = $request->get('trial') == 1;

        return view('settings.subscription.finish', compact(
            'stripeApiToken',
            'status',
            'availableCampaigns',
            'user',
            'currency',
            'current',
            'tracking',
            'gaTrackingEvent',
            'gaPurchase',
            'isPayPal',
            'isTrial',
        ));
    }
}
