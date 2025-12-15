<?php

namespace App\Http\Middleware\Campaigns;

use App\Facades\Domain;
use App\Models\Campaign;
use Closure;

class Boosted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        // Make sure we have an id
        /** @var Campaign $campaign */
        $campaign = $request->route('campaign');
        if (empty($campaign)) {
            return redirect()->route('login')
                ->withErrors(__('You\'ve been banned'));
        }

        if (! $campaign->boosted()) {
            if ($request->is('api/*') || Domain::isApi()) {
                return response()->json([
                    'error' => 'This feature is reserved to boosted campaigns.',
                ]);
            }

            return redirect()->route('dashboard', $campaign)->withErrors(__('crud.errors.boosted_campaigns', ['boosted' => __('concept.premium-campaigns')]));
        }

        return $next($request);
    }
}
