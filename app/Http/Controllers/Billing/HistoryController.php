<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * InvoiceController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $invoices = ! empty($user->stripe_id) ? $user->invoicesIncludingPending() : [];

        return view('billing.history', compact(
            'invoices'
        ));
    }

    /**
     * @param  string  $invoice
     */
    public function download(Request $request, $invoice)
    {
        /** @var User $user */
        $user = $request->user();
        $billing = '';
        if ($user->profile && ! empty($user->profile['billing'])) {
            $billing = $user->profile['billing'];
        }

        return $user->downloadInvoice($invoice, [
            'vendor' => 'Owlchester SNC',
            'product' => 'Kanka Subscription',
            'url' => config('app.url'),
            'street' => config('billing.street'),
            'location' => config('billing.location'),
            'country' => config('billing.country'),
            'email' => config('app.email'),
            'billing' => $billing,
        ]);
    }
}
