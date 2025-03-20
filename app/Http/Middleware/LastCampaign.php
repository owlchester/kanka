<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastCampaign
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guest()) {
            return $next($request);
        }

        // When a user looks at another campaign, track it for when they come back later to Kanka and log in
        $campaign = CampaignLocalization::getCampaign();
        if ($request->user()->last_campaign_id !== $campaign->id) {
            $request->user()->last_campaign_id = $campaign->id;
            $request->user()->saveQuietly();
        }

        return $next($request);
    }
}
