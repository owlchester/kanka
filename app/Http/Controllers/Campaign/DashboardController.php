<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignDashboard;
use App\Models\CampaignDashboard;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /** @var DashboardService  */
    protected $service;

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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();

        if (!$campaign->boosted()) {
            return view('dashboard.dashboards.unboosted')
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

    /**
     * @param StoreCampaignDashboard $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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
