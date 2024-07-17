<?php

namespace App\Http\Controllers;

use App\Models\Tier;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Http\Requests\ValidatePledge;
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
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $pledge = $response['purchase_units']['0']['reference_id'];
            $this->service
                ->user($request->user())
                ->subscribe($pledge);
            $routeOptions = ['success' => 1];
            $flash = 'subscribed';

            return redirect()
                ->route('settings.subscription', $routeOptions)
                ->with('success', __('settings.subscription.success.subscribed'))
                ->with('sub_tracking', $flash);
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
