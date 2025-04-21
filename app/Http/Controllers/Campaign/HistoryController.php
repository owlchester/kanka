<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Collection;

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

        $logs = UserLog::where('campaign_id', $campaign->id)->latest()->paginate();
        $users = new Collection;
        foreach ($logs as $log) {
            if (! $users->has($log->user_id)) {
                $users->put($log->user_id, User::find($log->user_id));
            }
        }

        return view('campaigns.history.index')
            ->with('campaign', $campaign)
            ->with('logs', $logs)
            ->with('users', $users);
    }
}
