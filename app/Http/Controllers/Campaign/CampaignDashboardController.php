<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignDashboard;
use App\Models\CampaignDashboard;
use App\Services\DashboardService;

class CampaignDashboardController extends Controller
{
    protected $service;

    public function __construct(DashboardService $dashboardsService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $dashboardsService;
    }

    public function index()
    {
        return redirect()->to('home');
    }

    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        return view('dashboard.dashboards.create')->with('campaign', $campaign);
    }

    public function store(StoreCampaignDashboard $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $dashboard = $this->service->campaign($campaign)->create($request);

        if ($dashboard) {
            return redirect()->route('dashboard.setup', ['dashboard' => $dashboard->id])
                ->with('success', __('dashboard.dashboards.create.success', ['name' => $dashboard->name]));
        }
        return redirect()->route('campaign_dashboards.create');
    }

    public function edit(CampaignDashboard $campaignDashboard)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        return view('dashboard.dashboards.update')
            ->with('campaign', $campaign)
            ->with('dashboard', $campaignDashboard);
    }

    public function update(CampaignDashboard $campaignDashboard, StoreCampaignDashboard $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $dashboard = $this->service->campaign($campaign)
            ->dashboard($campaignDashboard)
            ->update($request);

        return redirect()->route('dashboard.setup', ['dashboard' => $dashboard->id])
            ->with('success', __('dashboard.dashboards.update.success', ['name' => $dashboard->name]));
    }

    public function destroy(CampaignDashboard $campaignDashboard)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $campaignDashboard->delete();
        CampaignCache::clearDashboards();

        return redirect()->route('dashboard.setup')
            ->with('success', __('dashboard.dashboards.delete.success', ['name' => $campaignDashboard->name]));

    }
}
