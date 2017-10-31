<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Campaign
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
        $campaignId = Session::get('campaign_id');
        if (empty($campaignId)) {
            return redirect()->route('campaigns.index');
        }

        // Make sure the campaign exists
        $campaign = \App\Campaign::where('id', $campaignId)->first();
        if (empty($campaign)) {
            return redirect()->route('campaigns.index');
        }

        // Make sure we are in the campaign users
        if (!$campaign->member()) {
            return redirect()->route('campaigns.index');
        }

        return $next($request);
    }
}
