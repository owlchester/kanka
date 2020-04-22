<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * InvoiceController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'shadow']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $invoices = !empty($user->stripe_id) ? $user->invoicesIncludingPending() : [];

        return view('settings.invoices', compact(
            'invoices'
        ));
    }

    /**
     * @param Request $request
     * @param $invoice
     * @return mixed
     */
    public function download(Request $request, $invoice)
    {
        return $request->user()->downloadInvoice($invoice, [
            'vendor' => 'Kanka.io',
            'product' => 'Kanka Monthly Subscription',
        ]);
    }
}
