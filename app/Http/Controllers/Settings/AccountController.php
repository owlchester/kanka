<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSettingsAccount;
use App\Http\Requests\StoreProfile;
use App\Http\Requests\StoreSettingsAccount;
use App\Http\Requests\StoreSettingsAccountEmail;
use App\Http\Requests\StoreSettingsAccountSocial;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'shadow']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('settings.account');
    }

    /**
     * @param StoreSettingsAccount $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(StoreSettingsAccount $request)
    {
        Auth::user()->update($request->only('password_new'));

        return redirect()
            ->route('settings.account')
            ->with('success', trans('settings.account.password_success'));
    }

    /**
     * @param StoreSettingsAccountEmail $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email(StoreSettingsAccountEmail $request)
    {
        Auth::user()->update($request->only('email'));

        return redirect()
            ->route('settings.account')
            ->with('success', trans('settings.account.email_success'));
    }

    /**
     * @param StoreSettingsAccountSocial $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function social(StoreSettingsAccountSocial $request)
    {
        if (empty(Auth()->user()->provider)) {
            return redirect()
                ->route('settings.account')
                ->with('error', trans('settings.account.social.error'));
        }

        $data['provider'] = null;
        $data['provider_id'] = null;

        Auth::user()->update($data);

        return redirect()
            ->route('settings.account')
            ->with('success', trans('settings.account.social.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteSettingsAccount $request)
    {
        $user = Auth::user();
        $user->delete();
        return redirect()->route('home');
    }
}
