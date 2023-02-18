<?php

namespace App\Http\Middleware;

use App\Facades\CampaignLocalization;
use Closure;

class CampaignBoosted
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
            return redirect()->route('login')
                ->withErrors(__('I\'m confused?'));
        }

        if (!$campaign->boosted()) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'This feature is reserved to boosted campaigns.'
                ]);
            }
            return redirect()->route('dashboard', [$campaign])->withErrors(__('crud.errors.boosted'));
        }

        return $next($request);
    }
}
