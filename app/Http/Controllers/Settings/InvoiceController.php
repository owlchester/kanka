<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * InvoiceController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $invoices = !empty($user->stripe_id) ? $user->invoicesIncludingPending() : [];

        return view('settings.invoices', compact(
            'invoices'
        ));
    }

    /**
     * @param Request $request
     * @param string $invoice
     * @return mixed
     */
    public function download(Request $request, $invoice)
    {
        /** @var User $user */
        $user = $request->user();
        return $user->downloadInvoice($invoice, [
            'vendor' => 'Kanka.io',
            'product' => 'Kanka Monthly Subscription',
        ]);
    }
}
