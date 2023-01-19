<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserBillingStore;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    /**
     * PaymentMethodController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $stripeApiToken = config('cashier.key', null);
        $user = Auth::user();

        $translations = [
            'ending' => __('settings.subscription.payment_method.ending'),
            'add_one' => __('settings.subscription.payment_method.add_one'),
            'new_card' => __('settings.subscription.payment_method.new_card'),
            'card_name' => __('settings.subscription.payment_method.card_name'),
            'card' => __('settings.subscription.payment_method.card'),
            'helper' => __('settings.subscription.payment_method.helper'),
            'actions.add_new' => __('settings.subscription.payment_method.actions.add_new'),
            'actions.save' => __('settings.subscription.payment_method.actions.save'),
        ];
        $translations = json_encode($translations);

        return view('billing.payment-method', compact(
            'stripeApiToken',
            'user',
            'translations'
        ));
    }

    /**
     * @param UserBillingStore $request
     * @return mixed
     */
    public function save(UserBillingStore $request)
    {
        $user = Auth::user();
        $settings = $user->saveSettings($request->only('currency'));
        $user->save();

        $from = $request->get('from', 'billing.payment-method');

        return redirect()
            ->route($from)
            ->with('success', trans('settings.subscription.success.currency'));
    }
}
