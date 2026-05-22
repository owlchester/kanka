<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastLoginAt
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $today = Carbon::today();

            if (! $user->last_login_at || $user->last_login_at->lt($today)) {
                $user->updateQuietly(['last_login_at' => $today]);
            }
        }

        return $next($request);
    }
}
