<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\UserLog;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $cutoff = $campaign->premium() ? config('limits.campaigns.logs.premium') : config('limits.campaigns.logs.standard');
        $premium = config('limits.campaigns.logs.premium');
        $logs = UserLog::with(['user', 'impersonator'])
            ->where('campaign_id', $campaign->id)
            ->whereDate('created_at', '>=', \Carbon\Carbon::today()->subDays($premium)->format('Y-m-d'))
            ->latest()
            ->paginate();

        return view('campaigns.logs.index')
            ->with('campaign', $campaign)
            ->with('cutoff', $cutoff)
            ->with('premium', $premium)
            ->with('logs', $logs);
    }
}
