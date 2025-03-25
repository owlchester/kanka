<?php

namespace App\Http\Controllers;

use App\Enums\PricingPeriod;
use App\Http\Requests\ValidatePledge;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected PayPalService $service;

    public function __construct(PayPalService $service)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $service;
    }

    /**
     * process transaction.
     */
    public function processTransaction(ValidatePledge $request, Tier $tier)
    {
        if ($tier->isFree()) {
            abort(401);
        }
        if (request()->ajax()) {
            return response()->json();
        }
        $response = $this->service
            ->user($request->user())
            ->tier($tier)
            ->process();

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        } else {
            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
    }

    /**
     * Process a successful transaction
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $pledge = $response['purchase_units']['0']['reference_id'];
            Log::info('Paypal', $response);
            $this->service
                ->user($request->user())
                ->subscribe($pledge);
            $routeOptions = ['success' => 1];
            $flash = 'subscribed';

            /** @var ?Tier $tier */
            $tier = Tier::where('name', $pledge)->first();
            /** @var ?TierPrice $tierPrice */
            $tierPrice = $tier->prices()
                ->where('currency', $request->user()->currency())
                ->where('period', PricingPeriod::Yearly)
                ->first();

            return redirect()
                ->route('settings.subscription', $routeOptions)
                ->with('success', __('settings.subscription.success.subscribed'))
                ->with('sub_tracking', $flash)
                ->with('sub_id', $tierPrice?->id)
                ->with('sub_value', $response['purchase_units']['0']['payments']['captures'][0]['amount']['value']);
        } else {
            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
    }

    /**
     * cancel transaction
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('settings.subscription')
            ->with('error', __('settings.subscription.errors.callback'));
    }
}
