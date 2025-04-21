<?php

namespace App\Http\Controllers\Billing;

use App\Enums\UserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserBillingStore;
use App\Models\UserLog;
use App\Services\Users\CurrencyService;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    protected CurrencyService $currencyService;

    /**
     * PaymentMethodController constructor.
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
        $this->currencyService = $currencyService;
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

        $currencies = $this->currencyService->availableCurrencies();

        return view('billing.payment-method', compact(
            'stripeApiToken',
            'user',
            'translations',
            'currencies',
        ));
    }

    public function currency()
    {
        $content = auth()->user()->subscribed('kanka') ?
            '_blocked' : '_form';

        return view('settings.subscription.currency.edit')
            ->with('content', $content)
            ->with('currencies', $this->currencyService->availableCurrencies());
    }

    public function save(UserBillingStore $request)
    {
        $user = $request->user();

        $from = $request->get('from', 'billing.payment-method');

        if ($request->get('reset_billing') && ($request->get('currency') != $user->currency())) {
            $paymentMethods = $user->paymentMethods();

            foreach ($paymentMethods as $method) {
                $method->delete();
            }
            $user->subscriptions()->delete();

            $user->card_expires_at = null;
            $user->stripe_id = null;
            $user->log(UserAction::currencySwitch);
        }

        $user->saveSettings($request->only('currency'));
        $user->save();

        return redirect()
            ->route($from)
            ->with('success', __('settings.subscription.success.currency'));
    }
}
