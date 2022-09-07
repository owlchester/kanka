<?php

namespace App\Http\Middleware;

use App\Models\Google2FAAuthentication;


use Closure;

class Google2FAMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        if (!config('auth.2fa_enabled')) {
            return $next($request);
        }


        if ($request->is('cancel-2fa')) {
            auth()->logout();
            return $next($request);
        }
        // Send requested loggin User to Google2FA Authentication Support
        $authentication = app(Google2FAAuthentication::class)->boot($request);

        // (true)
        if ($authentication->isAuthenticated()) {

              // If User is Authenticated through 2FA then proceed
              return $next($request);
        }

        // (false)
        // If User is not Authenticated through 2FA return action getGoogle2FaSecretkey() on Google2FAAuthentication::class
        return $authentication->makeRequestOneTimePasswordResponse();
    }
}
