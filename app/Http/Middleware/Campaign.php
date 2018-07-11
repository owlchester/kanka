<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Campaign as CampaignModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Campaign
{
    public function handle($request, Closure $next)
    {
        // If the campaign has not been passed through the function
        // it tries to get it from the first segment of the url
        $segments = explode('-', $request->segment(2));
        $campaignId = !empty($segments) && !empty($segments[1]) ? $segments[1] : null;

        if (empty($campaignId)) {
            abort(404);
        }

        $campaign = CampaignModel::findOrFail($campaignId);

        // Make sure we can view this campaign?
        if ($campaign->visibility == 'public') {
            Session::put('campaign_id', $campaign->id);
            return $next($request);
        } elseif (Auth::check()) {
            // Obvious check: are we a member of the campaign?
            if (!$campaign->user()) {
                // Let's check if it's in Review mode, then we need to be an admin or moderator
                if ($campaign->visibility == \App\Campaign::VISIBILITY_REVIEW && !(Auth::user()->hasRole('moderator') || Auth::user()->hasRole('admin'))) {
                    abort(403);
                }
            }
        } else {
            // No session, nada.
            abort(403);
        }

        return $next($request);
    }
}
