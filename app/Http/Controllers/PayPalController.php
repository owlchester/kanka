<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Http\Requests\ValidatePledge;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected PaypalService $service;

    /**
     * AbilityController constructor.
     * @param PayPalService $service
     */
    public function __construct(PayPalService $service)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $service;
    }
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(ValidatePledge $request)
    {
        $response = $this->service
            ->user($request->user())
            ->process($request->get('tier'));

        if (auth()->user()->id === 1) {
            dd($response);
        }
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
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

            return redirect()
                ->route('settings.subscription', $routeOptions)
                ->with('success', __('settings.subscription.success.subscribed'));
        } else {
            return redirect()
                ->route('settings.subscription')
                ->with('error', __('settings.subscription.errors.failed', ['email' => config('app.email')]));
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('settings.subscription')
            ->with('error', __('settings.subscription.errors.callback'));
    }
}
