<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\UserLog;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        if (! app()->hasDebugModeEnabled()) {
            abort(404);
        }

        $logs = UserLog::with(['user', 'impersonator'])->where('campaign_id', $campaign->id)->latest()->paginate();

        return view('campaigns.logs.index')
            ->with('campaign', $campaign)
            ->with('logs', $logs);
    }
}
