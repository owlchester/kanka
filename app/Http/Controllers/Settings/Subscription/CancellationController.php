<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionCancel;
use App\Services\Subscription\CancellationService;
use Illuminate\Http\Request;

class CancellationController extends Controller
{
    protected CancellationService $service;

    public function __construct(
        CancellationService $service,
    ) {
        $this->middleware(['auth', 'identity', 'subscriptions']);
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->hasPayPal() || $user->subscription('kanka')?->onGracePeriod()) {
            return view('settings.subscription.cancellation.grace', compact(
                'user',
            ));
        }

        return view('settings.subscription.cancellation.form', compact(
            'user',
        ));
    }

    public function save(SubscriptionCancel $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        $this->service
            ->user($request->user())
            ->request($request)
            ->cancel();

        return redirect()
            ->route('settings.subscription', ['cancelled' => 1])
            ->with('success', __('settings.subscription.success.cancel'))
            ->with('sub_tracking', 'cancel')
            ->with('sub_value', 0);
    }
}
