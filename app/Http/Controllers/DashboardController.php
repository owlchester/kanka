<?php

namespace App\Http\Controllers;

use App\Enums\Widget;
use App\Facades\Dashboard;
use App\Facades\DataLayer;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}

    public function index(Campaign $campaign)
    {
        // Determine the user's dashboard
        $requestedDashboard = request()->get('dashboard');
        if ($requestedDashboard == 'default') {
            $requestedDashboard = -1;
        }
        if (auth()->check()) {
            $this->dashboardService->user(auth()->user());
        }
        $dashboard = $this
            ->dashboardService
            ->campaign($campaign)
            ->getDashboard((int) $requestedDashboard);
        $dashboards = $this->dashboardService->getDashboards();

        $widgets =
            CampaignDashboardWidget::onDashboard($dashboard)
                ->positioned()
                ->get();

        // A user with campaigns doesn't need this process.
        $gaTrackingEvent = null;
        $welcome = false;
        if (session()->has('user_registered')) {
            session()->remove('user_registered');
            $gaTrackingEvent = 'pa10CJTvrssBEOaOq7oC';
            DataLayer::newAccount();
            $welcome = true;
        }

        $hasMap = false;
        $hasCampaignHeader = $requestedDashboard === null;
        foreach ($widgets as $w) {
            if ($w->widget === Widget::Preview && $w->entity && $w->visible() && $w->entity->isMap()) {
                $hasMap = true;
            } elseif ($w->widget === Widget::Campaign) {
                $hasCampaignHeader = true;
            }
        }

        return view('home', compact(
            'campaign',
            'widgets',
            'dashboard',
            'dashboards',
            'welcome',
            'gaTrackingEvent',
        ))
            ->with('hasMap', $hasMap)
            ->with('hasCampaignHeader', $hasCampaignHeader);
    }

    /**
     * @param  int  $id
     */
    public function recent(Campaign $campaign, $id)
    {
        /** @var CampaignDashboardWidget $widget */
        $widget = CampaignDashboardWidget::findOrFail($id);
        if ($widget->widget != Widget::Recent) {
            return response()->json([
                'success' => true,
            ]);
        }

        $entities = $widget->entities();

        return view('dashboard.widgets._recent_list')
            ->with('campaign', $campaign)
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('campaign', $campaign);
    }

    /**
     * @param  int  $id
     */
    public function unmentioned(Campaign $campaign, $id)
    {
        /** @var CampaignDashboardWidget $widget */
        $widget = CampaignDashboardWidget::findOrFail($id);
        if ($widget->widget != Widget::Unmentioned) {
            return response()->json([
                'success' => true,
            ]);
        }

        $entities = \App\Models\Entity::unmentioned()
            ->inTags($widget->tags->pluck('id')->toArray())
            ->inTypes($widget->conf('entity'))
            ->with(['updater'])
            ->paginate(10);

        return view('dashboard.widgets._recent_list')
            ->with('campaign', $campaign)
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('campaign', $campaign);
    }
}
