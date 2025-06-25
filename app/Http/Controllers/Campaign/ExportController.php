<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\Exports\QueueService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct(protected QueueService $queueService)
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        return view('campaigns.export', compact('campaign'));
    }

    /**
     * Dispatch the campaign export jobs and have the user wait for a bit
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Request $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);
        if (request()->ajax()) {
            return response()->json();
        }

        if (! $request->user()->can('export', $campaign)) {
            return redirect()
                ->route('campaign.export', $campaign)
                ->withError(__('campaigns/export.errors.limit'));
        }

        $this->queueService
            ->campaign($campaign)
            ->user($request->user())
            ->queue();

        $adminRoleName = $campaign->adminRoleName();

        return redirect()
            ->route('campaign.export', $campaign)
            ->withSuccess(__('campaigns/export.success', [
                'admin' => $adminRoleName,
            ]));
    }
}
