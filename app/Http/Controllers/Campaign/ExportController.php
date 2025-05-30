<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct(public ExportService $exportService)
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

        $this->exportService
            ->campaign($campaign)
            ->user($request->user())
            ->queue();

        $role = \App\Facades\CampaignCache::adminRole();

        return redirect()
            ->route('campaign.export', $campaign)
            ->withSuccess(__('campaigns/export.success', [
                'admin' => \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')),
            ]));
    }
}
