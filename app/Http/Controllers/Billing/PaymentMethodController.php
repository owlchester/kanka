<?php

namespace App\Http\Controllers\Billing;

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserBillingStore;
use App\Services\Users\CurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

    public function index(): View
    {
        $user = Auth::user();
        $currencies = $this->currencyService->user($user)->availableCurrencies();

        return view('billing.payment-method', compact('user', 'currencies'));
    }

    public function portal(Request $request): RedirectResponse
    {
        if (! $request->user()->hasStripeId()) {
            return redirect()->route('billing.payment-method');
        }

        return $request->user()->redirectToBillingPortal(route('settings.subscription'));
    }

    public function currency()
    {
        $content = auth()->user()->subscribed('kanka') ?
            '_blocked' : '_form';

        return view('settings.subscription.currency.edit')
            ->with('content', $content)
            ->with('currencies', $this->currencyService->user(auth()->user())->availableCurrencies());
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

            $user->stripe_id = null;
            UserLogger::user($user)->log(UserAction::currencySwitch);
        }

        $user->saveSettings($request->only('currency'));
        $user->save();

        return redirect()
            ->route($from)
            ->with('success', __('settings.subscription.success.currency'));
    }
}
