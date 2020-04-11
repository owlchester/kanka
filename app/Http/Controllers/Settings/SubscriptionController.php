<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserSubscribeStore;
use App\Models\Patreon;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /** @var SubscriptionService */
    protected $subscription;

    /**
     * SubscriptionController constructor.
     * @param SubscriptionService $service
     */
    public function __construct(SubscriptionService $service)
    {
        $this->middleware('auth');
        $this->subscription = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $stripeApiToken = getenv('STRIPE_KEY', null);
        $status = $this->subscription->user(Auth::user())->status();
        $currentPlan = $this->subscription->currentPlan();
        $service = $this->subscription;
        $user = Auth::user();
        $currency = $user->currencySymbol();

        return view('settings.subscription.index', compact(
            'stripeApiToken',
            'status',
            'currentPlan',
            'user',
            'currency',
            'service'
        ));
    }

    /**
     * Change subscription modal
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function change(Request $request)
    {
        $tier = $request->get('tier');
        $amount = $this->subscription->user($request->user())->tier($tier)->amount();
        $card = $request->user()->hasPaymentMethod() ? Arr::first($request->user()->paymentMethods()): null;
        $intent = $request->user()->createSetupIntent();
        $cancel = $tier == Patreon::PLEDGE_KOBOLD;

        return view('settings.subscription.change', compact(
            'tier',
            'amount',
            'card',
            'intent',
            'cancel'
        ));
    }

    /**
     * Subscribe
     *
     * @param UserSubscribeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(UserSubscribeStore $request)
    {
        try {
            $this->subscription->user($request->user())
                ->tier($request->get('tier'))
                ->change($request);

            return redirect()
                ->route('settings.subscription')
                ->withSuccess(__('settings.subscription.success.subscribed'));
        } catch (\Exception $e) {
            // Error? json
            return response()->json([
                'error' => 'error_message',
            ]);
        }
    }
}
