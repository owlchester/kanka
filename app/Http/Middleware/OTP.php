<?php

namespace App\Http\Middleware;

use App\Facades\Identity;
use App\Models\OTPAuthentication;
use Closure;

class OTP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        if (! config('google2fa.enabled')) {
            return $next($request);
        }
        if ($request->is('*/settings/security/cancel2fa')) {
            auth()->logout();

            return $next($request);
        }
        // If the user is impersonating someone that has 2FA, don't ask for the user's OTP
        if ($request->user() && Identity::isImpersonating()) {
            return $next($request);
        }
        // Send requested logging User to OTP Authentication Support
        /** @var OTPAuthentication $authentication */
        $authentication = app(OTPAuthentication::class)->boot($request);

        if ($authentication->isAuthenticated()) {
            return $next($request);
        }

        return $authentication->makeRequestOneTimePasswordResponse();
    }
}
