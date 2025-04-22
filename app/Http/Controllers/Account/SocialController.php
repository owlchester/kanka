<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['identity', 'password.confirm']);
    }

    public function index()
    {
        if (empty(auth()->user()->provider)) {
            return redirect()
                ->route('settings.account')
                ->with('error', __('settings.account.social.error'));
        }

        return view('account.social.form')->with('user', auth()->user());
    }

    public function save(StoreSettingsAccount $request)
    {
        if (empty(auth()->user()->provider)) {
            return redirect()
                ->route('settings.account')
                ->with('error', __('settings.account.social.error'));
        }

        if ($request->ajax()) {
            return response()->json();
        }

        $data['provider'] = null;
        $data['provider_id'] = null;
        $data['password'] = Hash::make($request->post('password_new'));

        auth()->user()->update($data);
        Auth::logoutOtherDevices($request->get('password_new'));

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.social.success'));
    }
}
