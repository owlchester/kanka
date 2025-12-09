<?php

namespace App\Http\Controllers\Settings;

use App\Enums\PricingPeriod;
use App\Enums\UserAction;
use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserSubscribeStore;
use App\Jobs\Users\AbandonedCart;
use App\Models\Tier;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Services\SubscriptionUpgradeService;
use App\Services\Users\CurrencyService;
use App\Services\Users\EmailValidationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscription;

    protected SubscriptionUpgradeService $subscriptionUpgrade;

    protected EmailValidationService $emailValidation;

    protected CurrencyService $currencyService;

    /**
     * SubscriptionController constructor.
     */
    public function __construct(
        SubscriptionService $service,
        SubscriptionUpgradeService $subscriptionUpgradeService,
        EmailValidationService $validationService,
        CurrencyService $currencyService
    ) {
        $this->middleware(['auth', 'identity', 'subscriptions']);
        $this->subscription = $service;
        $this->subscriptionUpgrade = $subscriptionUpgradeService;
        $this->emailValidation = $validationService;
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $stripeApiToken = config('cashier.key');
        $this->currencyService->user($user)->setDefaultCurrency();
        $status = $this->subscription->user($user)->status();
        $current = $this->subscription->currentPlan();
        $currency = $user->currencySymbol();
        $tiers = Tier::with('prices')->ordered()->get();
        $isPayPal = $user->hasPayPal();
        $hasManual = $user->hasManualSubscription();

        return view('settings.subscription.index', compact(
            'stripeApiToken',
            'status',
            'user',
            'currency',
            'current',
            'tiers',
            'isPayPal',
            'hasManual',
        ));
    }

    public function change(Request $request, Tier $tier)
    {
        if ($tier->isFree()) {
            dd('Cancel instead');
        }
        /** @var User $user */
        $user = $request->user();
        $period = $request->get('period') === 'yearly' ? PricingPeriod::Yearly : PricingPeriod::Monthly;

        // If the user has a cancelled sub still ending
        if ($user->subscribed('kanka') && $user->subscription('kanka')->onGracePeriod() && ! $user->hasPayPal()) {
            if ($tier->isCurrent($user)) {
                return view('settings.subscription.renew')
                    ->with('user', $user);
            }

            return view('settings.subscription.change_blocked')
                ->with('user', $user);
        }

        $amount = $this->subscription
            ->user($request->user())
            ->tier($tier)
            ->period($period)
            ->amount();
        $card = $user->hasPaymentMethod() ? Arr::first($user->paymentMethods()) : null;
        if (empty($user->stripe_id)) {
            $user->createAsStripeCustomer();
        }
        $intent = $user->createSetupIntent();
        $isDowngrading = $this->subscription->downgrading();
        $isYearly = $period->isYearly();
        $hasPromo = true; // \Carbon\Carbon::create(2023, 11, 28)->isFuture();
        $limited = $this->subscription->isLimited();
        if ($user->hasPayPal() || $user->hasManualSubscription()) {
            $limited = true;
        }
        $upgrade = $this->subscriptionUpgrade
            ->user($user)
            ->tier($tier)
            ->period($period)
            ->upgradePrice();
        $currency = $user->currencySymbol();

        if ($user->isFrauding()) {
            $this->emailValidation->user($user)->requiresEmail();
        }

        if ($user->hasNewsletter()) {
            $delay = app()->isProduction() ? 30 : 1;
            AbandonedCart::dispatch(auth()->user(), $tier)->delay(now()->addMinutes($delay));
        }

        $nextBillingDate = Carbon::now();
        if ($period === PricingPeriod::Yearly) {
            $nextBillingDate->addYear();
        } else {
            $nextBillingDate->addMonth();
        }

        return view('settings.subscription.change', compact(
            'tier',
            'period',
            'amount',
            'card',
            'intent',
            'currency',
            'user',
            'upgrade',
            'isDowngrading',
            'hasPromo',
            'limited',
            'isYearly',
            'nextBillingDate'
        ));
    }

    public function renew(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([]);
        }
        try {
            $this->subscription
                ->user($request->user())
                ->renew();
            $request->user()->log(UserAction::subRenew);

            $routeOptions = [];

            return redirect()
                ->route('settings.subscription', $routeOptions)
                ->withSuccess(__('subscriptions.renew.success'));
        } catch (IncompletePayment $exception) {
            session()->put('subscription_callback', $request->get('payment_id'));

            return redirect()->route(
                'cashier.payment',
                // @phpstan-ignore-next-line
                [$exception->payment->id, 'redirect' => route('settings.subscription.callback')]
            );
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.subscription')
                ->with('error_raw', $e->getTranslatedMessage());
        } catch (Exception $e) {
            // Error? json
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Subscribe
     */
    public function subscribe(UserSubscribeStore $request, Tier $tier)
    {
        if ($request->user()->isFrauding()) {
            return redirect()
                ->route('settings.subscription')
                ->withError(__('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        try {
            $period = $request->get('period') === 'yearly' ? PricingPeriod::Yearly : PricingPeriod::Monthly;
            $this->subscription->user($request->user())
                ->tier($tier)
                ->period($period)
                ->coupon($request->get('coupon'))
                ->request($request->all())
                ->change()
                ->finish();

            return redirect()
                ->route('settings.subscription.finish')
                ->with('sub_tracking', 'subscribed')
                ->with('sub_value', $this->subscription->subscriptionValue())
                ->with('sub_coupon', $request->get('coupon'))
                ->with('sub_id', $this->subscription->tierPrice()->id);
        } catch (IncompletePayment $exception) {
            session()->put('subscription_callback', $request->get('payment_id'));

            return redirect()->route(
                'cashier.payment',
                // @phpstan-ignore-next-line
                [$exception->payment->id, 'redirect' => route('settings.subscription.callback')]
            );
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.subscription')
                ->with('error_raw', $e->getTranslatedMessage());
        } catch (Exception $e) {
            // If they are trying to sub in another currency, let's help them understand that issue
            $error = $e->getMessage();
            if (Str::contains($error, 'expected currency')) {
                preg_match_all('/`(\w{3})`/', $error, $currencies);

                return redirect()
                    ->route('settings.subscription')
                    ->with('error_raw', __('subscription.errors.invalid_currency', [
                        'old' => mb_strtoupper($currencies[1][0]),
                        'new' => mb_strtoupper($currencies[1][1]),
                        'email' => '<a href="mailto:' . config('app.email') . '" class="text-link">' . config('app.email') . '</a>',
                    ]));
            }

            // Error? json
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Stripe secure 3d callback page handler
     */
    public function callback(Request $request)
    {
        // Not expecting a callback
        if (! session()->has('subscription_callback')) {
            return redirect()
                ->route('settings.subscription');
        }

        // This contains our original request
        session()->remove('subscription_callback');

        if ($request->get('success')) {
            return redirect()
                ->route('settings.subscription')
                ->withSuccess(__('settings.subscription.success.callback'));
        }

        return redirect()
            ->route('settings.subscription')
            ->withError(__('settings.subscription.errors.callback'));
    }
}
