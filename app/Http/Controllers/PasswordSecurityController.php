<?php

namespace App\Http\Controllers;

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
    * Aborts login of user with 2fa enabled.
    */
    public function cancel2FA(Request $request)
    {
        return redirect()->route('login');
    }
}
