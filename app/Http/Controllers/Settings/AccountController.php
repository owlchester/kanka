<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSettingsAccount;
use App\Http\Requests\StoreProfile;
use App\Http\Requests\StoreSettingsAccount;
use App\Http\Requests\StoreSettingsAccountEmail;
use App\Http\Requests\StoreSettingsAccountSocial;
use App\Models\UserLog;
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
        $this->middleware(['auth', 'identity', 'password.confirm']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        return view('settings.account')
            ->with(compact('user'));
    }

    /**
     * @param StoreSettingsAccount $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(StoreSettingsAccount $request)
    {
        Auth::user()->update($request->only('password_new'));
        UserLog::create([
            'user_id' => auth()->user()->id,
            'type_id' => UserLog::TYPE_PASSWORD_UPDATE,
        ]);

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.password_success'));
    }

    /**
     * @param StoreSettingsAccountEmail $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email(StoreSettingsAccountEmail $request)
    {
        Auth::user()->update($request->only('email'));
        UserLog::create([
            'user_id' => auth()->user()->id,
            'type_id' => UserLog::TYPE_EMAIL_UPDATE,
        ]);

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.email_success'));
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
                ->with('error', __('settings.account.social.error'));
        }

        $data['provider'] = null;
        $data['provider_id'] = null;

        Auth::user()->update($data);
        UserLog::create([
            'user_id' => auth()->user()->id,
            'type_id' => UserLog::TYPE_SOCIAL_SWITCH,
        ]);

        return redirect()
            ->route('settings.account')
            ->with('success', __('settings.account.social.success'));
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
