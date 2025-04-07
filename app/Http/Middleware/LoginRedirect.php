<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LoginRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = ['roadmap'];

        // If to check where the request is coming from and set the variable if its a valid route.
        if ($request->has('next') && in_array($request->get('next'), $whitelist)) {
            session(['login_redirect' => route($request->get('next'))]);
        }

        return $next($request);
    }
}
