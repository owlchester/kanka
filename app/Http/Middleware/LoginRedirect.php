<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = ['roadmap', 'dashboard'];

        // If to check where the request is coming from and set the variable if its a valid route.
        if ($request->has('next')) {
            [$routeName, $campaignSlug] = array_pad(explode('.', $request->get('next'), 2), 2, null);

            if (in_array($routeName, $whitelist)) {
                try {
                    $params = $campaignSlug ? ['campaign' => $campaignSlug] : $request->except('next');
                    session(['login_redirect' => route($routeName, $params)]);
                } catch (\Exception) {
                    // Route generation failed, skip the redirect.
                }
            }
        }

        return $next($request);
    }
}
