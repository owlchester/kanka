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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isBanned()) {
            if (auth()->user()->banned_until < Carbon::now()->addDays(7)) {
                $days = auth()->user()->banned_until->diffInDays(Carbon::now());
                auth()->logout();
                return redirect()->route('login')->withErrors(
                    trans_choice('auth.banned.temporary', $days, ['days' => $days])
                );
            }
            auth()->logout();
            return redirect()->route('login')->withErrors(__('auth.banned.permanent'));
        }

        return $next($request);
    }
}
