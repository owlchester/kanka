<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;

class SetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        // Validate dashboard
        $dashboard = request()->has('dashboard') ? CampaignDashboard::where('id', request()->get('dashboard'))->first() : null;
        $dashboards = CampaignDashboard::exclude($dashboard)->orderBy('name')->get();

        $widgets = CampaignDashboardWidget::onDashboard($dashboard)->positioned()->get();

        return view('dashboard.setup')
            ->with('campaign', $campaign)
            ->with('dashboards', $dashboards)
            ->with('dashboard', $dashboard)
            ->with('widgets', $widgets);
    }

    /**
     * Save the new dashboard widgets order
     */
    public function save(Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        $position = 0;
        $widgets = (array) request()->post('widgets', []);
        foreach ($widgets as $i => $widget) {
            $wi = CampaignDashboardWidget::findOrFail($widget);
            $wi->update([
                'position' => $position,
            ]);
            $position++;
        }

        return response()->json([
            'success' => true,
            'message' => __('dashboard.setup.reorder.success'),
        ]);
    }
}
