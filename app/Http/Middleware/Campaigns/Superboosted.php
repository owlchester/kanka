<?php

namespace App\Http\Middleware\Campaigns;

use App\Facades\CampaignLocalization;
use App\Facades\Domain;
use Closure;

class Superboosted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        // Make sure we have an id
        $campaign = CampaignLocalization::getCampaign();
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
