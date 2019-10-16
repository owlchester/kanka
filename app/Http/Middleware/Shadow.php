<?php

namespace App\Http\Middleware;

use App\Facades\Identity as IdentityFacade;
use Closure;

class Shadow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If we are impersonating someone, move us back home
        if (getenv('APP_ENV') === 'shadow') {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
