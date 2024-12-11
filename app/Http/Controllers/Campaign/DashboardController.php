<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignDashboard;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $service;

    public function __construct(DashboardService $dashboardsService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => ['index', 'create']]);

        $this->service = $dashboardsService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->to('home');
    }

    public function create(Campaign $campaign)
    {
        if (!$campaign->boosted()) {
            return view('dashboard.dashboards.premium')
                ->with('campaign', $campaign);
        }

        $this->authorize('dashboard', $campaign);
        $source = null;
        if (request()->has('source')) {
            $source = CampaignDashboard::findOrFail(request()->get('source'));
        }

        return view('dashboard.dashboards.create')
            ->with('campaign', $campaign)
            ->with('source', $source);
    }

    public function store(StoreCampaignDashboard $request, Campaign $campaign)
    {
        if (!$campaign->boosted()) {
            return view('dashboard.dashboards.premium')
                ->with('campaign', $campaign);
        }

        $this->authorize('dashboard', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $dashboard = $this->service->campaign($campaign)->create($request);

        return redirect()->route('dashboard.setup', [$campaign, 'dashboard' => $dashboard->id])
            ->with('success', __('dashboard.dashboards.create.success', ['name' => $dashboard->name]));
    }

    public function edit(Campaign $campaign, CampaignDashboard $campaignDashboard)
    {
        $this->authorize('dashboard', $campaign);

        return view('dashboard.dashboards.update')
            ->with('campaign', $campaign)
            ->with('dashboard', $campaignDashboard);
    }

    public function update(Campaign $campaign, CampaignDashboard $campaignDashboard, StoreCampaignDashboard $request)
    {
        $this->authorize('dashboard', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $dashboard = $this->service->campaign($campaign)
            ->dashboard($campaignDashboard)
            ->update($request);

        return redirect()->route('dashboard.setup', [$campaign, 'dashboard' => $dashboard->id])
            ->with('success', __('dashboard.dashboards.update.success', ['name' => $dashboard->name]));
    }

    public function destroy(Campaign $campaign, CampaignDashboard $campaignDashboard)
    {
        $this->authorize('dashboard', $campaign);
        if (request()->ajax()) {
            return response()->json();
        }

        $campaignDashboard->delete();
        CampaignCache::clear();

        return redirect()->route('dashboard.setup', $campaign)
            ->with('success', __('dashboard.dashboards.delete.success', ['name' => $campaignDashboard->name]));
    }
}
