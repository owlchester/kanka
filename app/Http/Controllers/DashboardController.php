<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Facades\Dashboard;
use App\Facades\PostCache;
use App\Models\CampaignDashboardWidget;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Check the campaign
        $campaign = CampaignLocalization::getCampaign();
        if (empty($campaign) && (Auth::check() && !Auth::user()->hasCampaigns())) {
            return redirect()->route('start');
        }

        $user = null;
        $settings = null;
        if (Auth::check() && Auth::user()->can('dashboard', $campaign)) {
            $settings = true;
        }

        // Determine the user's dashboard
        $requestedDashboard = request()->get('dashboard');
        if ($requestedDashboard == 'default') {
            $requestedDashboard = -1;
        }
        $dashboard = Dashboard::campaign($campaign)
            ->getDashboard((int) $requestedDashboard);
        $dashboards = Dashboard::getDashboards();

        $widgets = CampaignDashboardWidget::onDashboard($dashboard)->positioned()->get();

        // Prepare unread releases
        $releases = PostCache::latest();
        if (!auth()->check() || \App\Facades\Identity::isImpersonating()) {
            $releases = [];
        } else {
            $unreadReleases = [];
            foreach ($releases as $release) {
                if (!$release->alreadyRead()) {
                    $unreadReleases[] = $release;
                }
            }
            $releases = $unreadReleases;
        }

        // A user with campaigns doesn't need this process.
        $gaTrackingEvent = null;
        $welcome = false;
        if (session()->has('user_registered')) {
            session()->remove('user_registered');
            $gaTrackingEvent = 'pa10CJTvrssBEOaOq7oC';
            $welcome = true;
        }

        return view('home', compact(
            'campaign',
            'settings',
            'releases',
            'widgets',
            'dashboard',
            'dashboards',
            'welcome',
            'gaTrackingEvent',
        ));
    }

    /**
     * @param $id
     * @return bool
     */
    public function recent($id)
    {
        /** @var CampaignDashboardWidget $widget */
        $widget = CampaignDashboardWidget::findOrFail($id);
        $campaign = CampaignLocalization::getCampaign();
        if ($widget->widget != CampaignDashboardWidget::WIDGET_RECENT) {
            return response()->json([
                'success' => true
            ]);
        }

        $entities = $widget->entities();

        return view('dashboard.widgets._recent_list')
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('campaign', $campaign)
        ;
    }

    /**
     * @param $id
     * @return bool
     */
    public function unmentioned($id)
    {
        $widget = CampaignDashboardWidget::findOrFail($id);
        $campaign = CampaignLocalization::getCampaign();
        if ($widget->widget != CampaignDashboardWidget::WIDGET_UNMENTIONED) {
            return response()->json([
                'success' => true
            ]);
        }

        $entities = \App\Models\Entity::unmentioned()
            ->inTags($widget->tags->pluck('id')->toArray())
            ->type($widget->conf('entity'))
            ->acl()
            ->with(['updater'])
            ->paginate(10);

        return view('dashboard.widgets._recent_list')
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('campaign', $campaign)
        ;
    }
}
