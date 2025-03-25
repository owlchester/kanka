<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocol
{
    /**
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->secure() && config('app.force_https') === true) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
