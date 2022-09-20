<?php

namespace App\Http\Middleware;

use App\Models\Google2FAAuthentication;


use Closure;

class TFAMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \Closure $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        if (!config('google2fa.enabled')) {
            return $next($request);
        }
        if ($request->is('*/settings/security/cancel-2fa')) {
            auth()->logout();
            return $next($request);
        }
        // Send requested loggin User to Google2FA Authentication Support
        $authentication = app(Google2FAAuthentication::class)->boot($request);

        if ($authentication->isAuthenticated()) {
            return $next($request);
        }
        return $authentication->makeRequestOneTimePasswordResponse();
    }
}
