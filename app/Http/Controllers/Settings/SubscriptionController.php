<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /** @var SubscriptionService */
    protected $subscription;

    public function __construct(SubscriptionService $service)
    {
        $this->middleware('auth');
        $this->subscription = $service;
    }

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

    public function cancel(Request $request)
    {
        $this->middleware('subscribed');

        $this->subscription->user(Auth::user())->cancel($request->get('reason'));


        return redirect()
            ->route('settings.subscription')
            ->withSuccess(__('settings.subscription.success.cancel'));
    }
}
