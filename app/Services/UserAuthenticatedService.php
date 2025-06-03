<?php

namespace App\Services;

use App\Models\User;

class UserAuthenticatedService
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(User $user)
    {
        // If the user is login in from a 403 page, go there now first
        $redirectTo = session()->get('login_redirect');
        if (! empty($redirectTo)) {
            session()->remove('login_redirect');
            // 2FA redirects are handled by the OTP middleware
            if (config('google2fa.enabled')) {
                session(['2fa_redirect' => $redirectTo]);
            }

            return redirect()->to($redirectTo);
        }

        return redirect()->route('home');
    }
}
