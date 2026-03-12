<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIfUserBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest() || ! auth()->user()->isBanned()) {
            return $next($request);
        }

        // If banned for less than 7 days, tell the user as much
        if (auth()->user()->banned_until < Carbon::now()->addDays(7)) {
            $days = auth()->user()->banned_until->diffInDays(Carbon::now());
            auth()->logout();

            return redirect()->route('login')->with(
                'error',
                trans_choice('auth.banned.temporary', $days, ['days' => $days])
            );
        }
        auth()->logout();

        return redirect()->route('login')->with('error', __('auth.banned.permanent'));
    }
}
