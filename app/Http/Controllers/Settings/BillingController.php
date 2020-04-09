<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserBillingStore;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{

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
        $user = Auth::user();

        return view('settings.subscription.billing', compact(
            'stripeApiToken',
            'user'
        ));
    }

    /**
     * @param UserBillingStore $request
     * @return mixed
     */
    public function save(UserBillingStore $request)
    {
        $user = Auth::user();
        $user->currency = $request->get('currency') ?? null;
        $user->save();

        return redirect()
            ->route('settings.billing')
            ->with('success', trans('settings.subscription.success.currency'));
    }
}
