<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && config('app.force_https') === true) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
