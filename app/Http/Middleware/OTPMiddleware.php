<?php

namespace App\Http\Middleware;

use App\Models\Google2FAAuthentication;
use Closure;
use App\Facades\Identity;

class OTPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (!config('google2fa.enabled')) {
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
        // Send requested logging User to Google2FA Authentication Support
        /** @var Google2FAAuthentication $authentication */
        $authentication = app(Google2FAAuthentication::class)->boot($request);

        if ($authentication->isAuthenticated()) {
            return $next($request);
        }
        return $authentication->makeRequestOneTimePasswordResponse();
    }
}
