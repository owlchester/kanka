<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckIfUserBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest() || !auth()->user()->isBanned()) {
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
