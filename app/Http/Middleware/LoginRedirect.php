<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

class LoginRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        // Store the previous URL in session only if it's not the login route itself and is a valid redirect url
        if ($request->is('login') || $request->is('register')) {
            //If to check where the request is coming from and set the variable if its a valid route.
            if (url()->previous() === route('roadmap')) {
                session(['login_redirect' => url()->previous()]);
            } elseif (!(url()->previous() === route('login')) && !(url()->previous() === route('register'))) {
                //If the user moves outside the login page, reset the redirect variable.
                session(['login_redirect' => null]);
            }
        } 

        return $next($request);
    }
}
