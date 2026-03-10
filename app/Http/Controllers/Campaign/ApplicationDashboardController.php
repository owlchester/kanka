<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\Widget;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;

class ApplicationDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        $hasJoinWidget = $campaign->widgets()->where('widget', Widget::Join)->exists();

        return view('campaigns.applications.dashboard_widget')
            ->with('campaign', $campaign)
            ->with('hasJoinWidget', $hasJoinWidget);
    }

    public function store(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        if (! $campaign->widgets()->where('widget', Widget::Join)->exists()) {
            CampaignDashboardWidget::create([
                'campaign_id' => $campaign->id,
                'widget' => Widget::Join,
                'dashboard_id' => null,
            ]);
        }

        return redirect()
            ->route('applications.index', $campaign)
            ->with('success', __('campaigns/applications.dashboard_widget.success'));
    }
}
