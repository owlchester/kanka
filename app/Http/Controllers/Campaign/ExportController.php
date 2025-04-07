<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected ExportService $service;

    public function __construct(ExportService $exportService)
    {
        $this->middleware('auth');
        $this->service = $exportService;
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

        if (! $request->user->can('export', $campaign)) {
            return response()->json(['error' => __('campaigns/export.errors.limit')]);
        }
        if (request()->ajax()) {
            return response()->json();
        }

        $this->service
            ->campaign($campaign)
            ->user($request->user())
            ->queue();

        return redirect()
            ->route('campaign.export', $campaign)
            ->withSuccess(__('campaigns/export.success'));
    }
}
