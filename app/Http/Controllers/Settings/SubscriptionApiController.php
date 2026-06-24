<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateCoupon;
use App\Models\Tier;
use App\Models\User;
use App\Services\Subscription\CouponService;
use App\Services\SubscriptionService;

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
