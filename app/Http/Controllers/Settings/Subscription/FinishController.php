<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Facades\DataLayer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Settings\SubscriptionController;
use App\Models\Campaign;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\Campaign\BoostService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class FinishController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService,
        protected BoostService $boostService,
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
        $gaPurchase = null;
        if (! empty($tracking)) {
            DataLayer::newSubscriber();
            DataLayer::add('userSubValue', session('sub_value'));
        }

        if (! empty($newSubPricingId)) {
            /** @var TierPrice $pricing */
            $pricing = TierPrice::find($newSubPricingId);
            DataLayer::add('userSubYearly', $pricing->isYearly() ? '1' : '0');
            DataLayer::add('userSubMonthly', ! $pricing->isYearly() ? '1' : '0');
            DataLayer::add('userSubPeriod', $pricing->isYearly() ? 'yearly' : 'monthly');
            $gaPurchase = [
                'value' => $pricing->cost,
                'currency' => $pricing->currency,
                'coupon' => session()->get('sub_coupon'),
                'item_id' => $pricing->tier->id,
                'item_name' => $pricing->tier->name . ($pricing->isYearly() ? ' Yearly' : null),
            ];
        }

        $premiumCampaign = $this->assignPremiumCampaign($user);
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
            'gaPurchase',
            'isTrial',
            'premiumCampaign',
        ));
    }

    private function assignPremiumCampaign(User $user): ?Campaign
    {
        if (! session()->pull(SubscriptionController::SUCCESS_SESSION_KEY, false)) {
            return null;
        }

        $campaignId = session()->pull(SubscriptionController::CAMPAIGN_SESSION_KEY);
        $campaign = $campaignId
            ? Campaign::acl($campaignId)->first()
            : ($user->campaigns()->count() === 1 ? $user->campaigns()->first() : null);

        if (
            ! $campaign
            || $user->hasBoosterNomenclature()
            || $campaign->premium()
            || $user->availableBoosts() < 1
        ) {
            return null;
        }

        $this->boostService
            ->user($user)
            ->campaign($campaign)
            ->premium(automaticallyAssigned: true);

        return $campaign;
    }
}
