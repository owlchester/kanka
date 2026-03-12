<?php

namespace App\Http\Middleware\Campaigns;

use App\Facades\Domain;
use App\Models\Campaign;
use Closure;
use Illuminate\Http\Request;

class Superboosted
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     */
    public function handle($request, Closure $next)
    {
        // Make sure we have an id
        /** @var Campaign $campaign */
        $campaign = $request->route('campaign');
        if (empty($campaign)) {
            return redirect()->route('home');
        }

        if (! $campaign->superboosted()) {
            if ($request->is('api/*') || Domain::isApi()) {
                return response()->json([
                    'error' => 'This feature is reserved to premium campaign.',
                ]);
            }

            return redirect()->route('dashboard', $campaign)->withErrors(__('campaigns.errors.premium'));
        }

        return $next($request);
    }
}
