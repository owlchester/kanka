<?php

namespace App\Http\Middleware;

use App\Facades\Identity as IdentityFacade;
use Closure;
use Illuminate\Http\Request;

class Identity
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     */
    public function handle($request, Closure $next)
    {
        // If we are impersonating someone, move us back home
        if (IdentityFacade::isImpersonating()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
