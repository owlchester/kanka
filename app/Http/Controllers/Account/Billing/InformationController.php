<?php

namespace App\Http\Controllers\Account\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillingSettings;
use App\Models\User;

class InformationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['identity']);
    }

    public function index()
    {
        return view('account.billing.information.form')->with('user', auth()->user());
    }

    public function save(StoreBillingSettings $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        /** @var User $user */
        $user = $request->user();
        $user->updateBillingInfo($request->profile['billing'])
            ->update();

        return redirect()
            ->route('billing.payment-method')
            ->with('success', trans('settings.profile.success'));
    }
}
