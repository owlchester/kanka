<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordSecurity;

class PasswordSecurityController extends Controller
{
    public function show2faForm()
    {
        if (Auth::guest()) {
            return;
        }

        $user = Auth::user();

        $google2FaUrl = '';

        // If User has 2FA current disabled generate QR code
        if (isset($user->PasswordSecurity)) {
            $google2Fa = new Google2FA();
            $google2Fa->setAllowInsecureCallToGoogleApis(true);
            $google2FaUrl = $google2Fa->getQRCodeGoogleUrl(
                $user->name,
                $user->email,
                $user->PasswordSecurity->google2fa_secret
            );
        }

        $data = array(
            'user' => $user,
            'google2FaUrl' => $google2FaUrl
        );

        return view('settings.account')->with('data', $data);
    }

    public function generate2faSecretCode(Request $request)
    {
        $user = Auth::user();

        $google2Fa = new Google2FA();

        // Generate a new Google2FA code for User
        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2Fa->generateSecretKey()
        ]);

        return redirect()->route('settings.account')->with('success', 'Success, you secret key has been generated. Please verify to enable');
    }


    public function enable2fa(Request $request)
    {
        $user = Auth::user();

        // Enable Google2FA if Google Authenticator code matches secret
        $google2Fa = new Google2FA();
        $secret = $request->input('verifyCode');
        $valid = $google2Fa->verifyKey($user->PasswordSecurity->google2fa_secret, $secret);

        // If Google2FA code is valid enable Google2FA
        if ($valid) {
            $user->PasswordSecurity->google2fa_enable = 1;
            $user->PasswordSecurity->save();
            return redirect()->route('settings.account')->with('success', 'Success, 2FA is anabled.');

        // Else redirect with invalid code error
        } else {
            return redirect()->route('settings.account')->with('error', 'Invalid Code, try again.');
        }
    }

    public function disable2fa(Request $request)
    {
        $user = Auth::user();

        // Update disabling Google2FA
        $user->PasswordSecurity->google2fa_enable = 0;
        $user->PasswordSecurity->save();

        return redirect()->route('settings.account')->with('success', 'Success 2FA is disabled.');
    }


    public function cancel2FA(Request $request)
    {

        return redirect()->route('home');
    }
}
