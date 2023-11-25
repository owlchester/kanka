<?php

namespace App\Http\Controllers\Settings;

use App\Facades\DataLayer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserAltSubscribeStore;
use App\Http\Requests\Settings\UserSubscribeStore;
use App\Models\Pledge;
use App\Models\SubscriptionCancellation;
use Carbon\Carbon;
use App\Services\SubscriptionService;
use App\Services\SubscriptionUpgradeService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscription;
    protected SubscriptionUpgradeService $subscriptionUpgrade;

    /**
     * SubscriptionController constructor.
     */
    public function __construct(SubscriptionService $service, SubscriptionUpgradeService $subscriptionUpgradeService)
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
        $this->subscription = $service;
        $this->subscriptionUpgrade = $subscriptionUpgradeService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $stripeApiToken = config('cashier.key', null);
        $status = $this->subscription->user($user)->status();
        $currentPlan = $this->subscription->currentPlan();
        $service = $this->subscription;
        $currency = $user->currencySymbol();
        $invoices = !empty($user->stripe_id) ? $user->invoices(true, ['limit' => 3]) : [];
        $tracking = session()->get('sub_tracking');
        $gaTrackingEvent = null;
        if (!empty($tracking)) {
            $gaTrackingEvent = 'TJhYCMDErpYDEOaOq7oC';
            if ($tracking === 'subscribed') {
                DataLayer::newSubscriber();
                DataLayer::add('userSubValue', session('sub_value'));
            } else {
                DataLayer::newCancelledSubscriber();
            }
        }

        return view('settings.subscription.index', compact(
            'stripeApiToken',
            'status',
            'currentPlan',
            'user',
            'currency',
            'service',
            'invoices',
            'tracking',
            'gaTrackingEvent',
        ));
    }

    /**
     * Change subscription modal
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function change(Request $request)
    {
        $user = $request->user();
        $tier = $request->get('tier');
        $period = $request->get('period', 'monthly');

        $amount = $this->subscription->user($request->user())->tier($tier)->period($period)->amount();
        $card = $user->hasPaymentMethod() ? Arr::first($user->paymentMethods()) : null;
        if (empty($user->stripe_id)) {
            $user->createAsStripeCustomer();
        }
        $intent = $user->createSetupIntent();
        $cancel = $tier == Pledge::KOBOLD;
        $isDowngrading = $this->subscription->downgrading();
        $isYearly = $period === 'yearly';
        $hasPromo = \Carbon\Carbon::create(2023, 11, 28)->isFuture();
        $limited = $this->subscription->isLimited();
        if ($user->hasPayPal()) {
            $limited = true;
        }
        $upgrade = $this->subscriptionUpgrade->user($user)->upgradePrice($period, $tier);
        $currency = $user->currencySymbol();

        return view('settings.subscription.change', compact(
            'tier',
            'period',
            'amount',
            'card',
            'intent',
            'cancel',
            'currency',
            'user',
            'upgrade',
            'isDowngrading',
            'hasPromo',
            'limited',
            'isYearly',
        ));
    }

    /**
     * Subscribe
     */
    public function subscribe(UserSubscribeStore $request)
    {
        if ($request->user()->isFrauding()) {
            return redirect()
                ->route('settings.subscription')
                ->withError(__('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
        try {
            $this->subscription->user($request->user())
                ->tier($request->get('tier'))
                ->period($request->get('period'))
                ->coupon($request->get('coupon'))
                ->change($request->all())
                ->finish();

            $flash = 'subscribed';
            $routeOptions = ['success' => 1];
            if ($this->subscription->canceled()) {
                $flash = 'cancel';
                $routeOptions = ['cancelled' => 1];
                SubscriptionCancellation::create([
                    'user_id' => $request->user()->id,
                    'reason' => $request->reason,
                    'custom' => $request->reason_custom,
                    'tier'  => $request->user()->pledge,
                    // @phpstan-ignore-next-line
                    'duration' => $request->user()->subscription('kanka')->created_at->diffInDays(Carbon::now()),
                ]);
            }

            return redirect()
                ->route('settings.subscription', $routeOptions)
                ->withSuccess(__('settings.subscription.success.' . $flash))
                ->with('sub_tracking', $flash)
                ->with('sub_value', $this->subscription->subscriptionValue());
        } catch (IncompletePayment $exception) {
            session()->put('subscription_callback', $request->get('payment_id'));
            return redirect()->route(
                'cashier.payment',
                // @phpstan-ignore-next-line
                [$exception->payment->id, 'redirect' => route('settings.subscription.callback')]
            );
        } catch (Exception $e) {
            // Error? json
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function altSubscribe(UserAltSubscribeStore $request)
    {
        $source = $this->subscription->user($request->user())
            ->tier($request->get('tier'))
            ->period($request->get('period'))
            ->method($request->get('method'))
            ->prepare($request);

        // @phpstan-ignore-next-line
        return redirect($source->redirect->url);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function altCallback(Request $request)
    {
        if ($this->subscription->validSource($request->get('source'))) {
            return redirect()
                ->route('settings.subscription')
                ->withSuccess(__('settings.subscription.success.alternative'));
        } else {
            return redirect()
                ->route('settings.subscription')
                ->withErrors(__('settings.subscription.errors.callback'));
        }
    }

    /**
     * Stripe secure 3d callback page handler
     */
    public function callback(Request $request)
    {
        // Not expecting a callback
        if (!session()->has('subscription_callback')) {
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
