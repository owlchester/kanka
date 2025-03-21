<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UserEnableTfa;
use App\Models\PasswordSecurity;
use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

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
        $user = $request->user();

        $otp = new Google2FA;

        // Generate a new Google2FA code for User
        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $otp->generateSecretKey(),
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

        // Enable OTP if the Authenticator code matches secret
        $otp = new Google2FA;
        $secret = $request->input('otp');
        $valid = $otp->verifyKey($user->passwordSecurity->google2fa_secret, $secret);

        // If OTP code is valid enable OTP
        if ($valid) {
            $user->passwordSecurity->update(['google2fa_enable' => 1]);
            // 2FA is enabled, log out the user and ask them to set up.
            auth()->logout();
            session()->flush();

            return redirect()->route('login')->with('success', __('settings.account.2fa.success_enable'));
        }

        return redirect()->route('settings.account')->with('error', __('settings.account.2fa.error_enable'));
    }

    /*
    * Disables 2fa for the current user.
    */
    public function disable2fa(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        // Update disabling OTP
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
