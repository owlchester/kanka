<?php

namespace App\Http\Middleware;

use Closure;
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
        $campaignId = Session::get('campaign_id');
        if (empty($campaignId)) {
            return redirect()->route('campaigns.index');
        }
        $campaign = \App\Campaign::where('id', $campaignId)->get();
        if (empty($campaign)) {
            return redirect()->route('campaigns.index');
        }

        return $next($request);
    }
}
