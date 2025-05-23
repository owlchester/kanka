<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Facades\DataLayer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelledController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        // If the user doesn't have an ending sub, send them back to the subscription page
        if (! $user->subscription('kanka')?->ends_at) {
            return redirect()
                ->route('settings.subscription');
        }
        $tracking = session()->get('sub_tracking');

        $gaTrackingEvent = null;
        if (! empty($tracking)) {
            $gaTrackingEvent = 'TJhYCMDErpYDEOaOq7oC';
            if ($tracking === 'cancel') {
                DataLayer::newCancelledSubscriber();
            }
        }

        $endDate = $user->subscription('kanka')?->ends_at->isoFormat('MMMM D, Y');

        return view('settings.subscription.cancelled')
            ->with('user', $user)
            ->with('endDate', $endDate)
            ->with('gaTrackingEvent', $gaTrackingEvent);
    }
}
