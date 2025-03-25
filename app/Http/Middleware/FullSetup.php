<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FullSetup
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // As Kanka is open source and people can host it, some stuff ends up on google search and can lead people
        // to the "wrong" kanka. This middleware makes sure that people who don't have some parts of the app set
        // up (ie a valid stripe integration, which is forbidden in our TOS), some page can't be accessed.
        if (! config('services.stripe.enabled')) {
            abort(404);
        }

        return $next($request);
    }
}
