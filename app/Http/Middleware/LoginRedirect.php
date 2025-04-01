<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = ['roadmap'];

        // Store the previous URL in session only if it's not the login route itself and is a valid redirect url
        if ($request->is('login') || $request->is('register')) {
            // If to check where the request is coming from and set the variable if its a valid route.
            if ($request->has('next') && in_array($request->get('next'), $whitelist)) {
                session(['login_redirect' => route($request->get('next'))]);

            } elseif (! (strtok(url()->previous(), '?') === route('login')) && ! (strtok(url()->previous(), '?') === route('register'))) {
                // If the user moves outside the login page, reset the redirect variable.
                session(['login_redirect' => null]);
            }
        }

        return $next($request);
    }
}
