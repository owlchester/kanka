<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsAccountEmail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['identity', 'password.confirm']);
    }

    public function index()
    {
        return view('account.email.form')->with('user', auth()->user());
    }

    public function save(StoreSettingsAccountEmail $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        auth()->user()->update($request->only('email'));

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.email_success'));
    }
}
