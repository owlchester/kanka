<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use Closure;

class CampaignSuperBoosted
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
        // Make sure we have an id
        $campaign = CampaignLocalization::getCampaign();
        if (empty($campaign)) {
            return redirect()->route('home');
        }

        if (!$campaign->superboosted()) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'This feature is reserved to premium campaign.'
                ]);
            }
            return redirect()->route('dashboard')->withErrors(__('campaigns.errors.premium'));
        }

        return $next($request);
    }
}
