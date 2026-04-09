<?php

namespace App\Http\Controllers\Subscription\PayPal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidatePledge;
use App\Models\Tier;
use App\Services\Subscription\PayPalRenewalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class RenewalController extends Controller
{
    public function __construct(protected PayPalRenewalService $service)
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->can('renewPaypalSubscription', $user)) {
            return redirect()
            ->route('settings.subscription')
            ->with('error', __('subscriptions/paypal-renew.errors.permission'));
        }

        $tiers = Tier::ordered()->get()->reject(fn (Tier $tier) => $tier->isFree());

        return view('settings.subscription.paypal-renew', compact('user', 'tiers'));
    }

    public function process(ValidatePledge $request, Tier $tier)
    {
        $this->authorize('renewPaypalSubscription', $request->user());

        if ($tier->isFree()) {
            abort(401);
        }

        $response = $this->service
            ->user($request->user())
            ->tier($tier)
            ->process();

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        Log::error('PayPal renewal process error', $response);

        return redirect()
            ->route('settings.subscription')
            ->with('error', __('subscriptions/paypal.errors.failed') . ' ' . __('subscriptions/paypal.errors.contact', ['email' => config('app.email')]));
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $tierName = $response['purchase_units']['0']['reference_id'];
            $tier = Tier::where('name', $tierName)->firstOrFail();

            Log::info('PayPal renewal', $response);

            $this->service
                ->user($request->user())
                ->renew($tier);

            return redirect()
                ->route('settings.subscription')
                ->with('success', __('subscriptions.renew.success', ['date' => $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y')]));
        }

        Log::error('PayPal renewal capture error', $response);

        return redirect()
            ->route('settings.subscription')
            ->with('error', __('subscriptions/paypal.errors.incomplete') . ' ' . __('subscriptions/paypal.errors.contact', ['email' => config('app.email')]));
    }

    public function cancel()
    {
        return redirect()
            ->route('settings.subscription')
            ->with('error', __('settings.subscription.errors.callback'));
    }
}
