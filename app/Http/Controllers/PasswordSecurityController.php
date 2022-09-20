<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UserEnableTfa;
use App\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordSecurity;

class PasswordSecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('2fa');
    }

    /*
    * Generates secret code for 2fa
    */
    public function generate2faSecretCode(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $google2Fa = new Google2FA();

        // Generate a new Google2FA code for User
        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2Fa->generateSecretKey()
        ]);
        return redirect()->route('settings.account')->with('success', __('settings.account.2fa.success_key'));
    }

    /*
    * Enables 2fa for the current user.
    */
    public function enable2fa(UserEnableTfa $request)
    {
        /** @var User $user */
        $user = $request->user();

        // Enable Google2FA if Google Authenticator code matches secret
        $google2Fa = new Google2FA();
        $secret = $request->input('otp');
        $valid = $google2Fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);

        // If Google2FA code is valid enable Google2FA
        if ($valid) {
            $user->passwordSecurity->update(['google2fa_enable' => 1]);
            // Don't directly request 2FA from the user, but instead log them out to confirm that it works
            auth()->logout();
            session()->flush();
            return redirect()->route('login')->with('success', __('settings.account.2fa.success_enable'));
            return redirect()->route('settings.account')->with('success', __('settings.account.2fa.success_enable'));
        }
        return redirect()->route('settings.account')->with('error', __('settings.account.2fa.error_enable'));
    }

    /*
    * Disables 2fa for the current user.
    */
    public function disable2fa(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Update disabling Google2FA
        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();

        return redirect()->route('settings.account')->with('success', __('settings.account.2fa.success_disable'));
    }

    /*
    * Aborts login of user with 2fa enabled.
    */
    public function cancel2FA(Request $request)
    {
        return redirect()->route('login');
    }
}
