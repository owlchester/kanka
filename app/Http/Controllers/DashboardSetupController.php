<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\CampaignDashboardWidget;

class DashboardSetupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $widgets = CampaignDashboardWidget::orderBy('position', 'asc')->get();

        return view('dashboard.setup')
            ->with('campaign', $campaign)
            ->with('widgets', $widgets);
    }
}