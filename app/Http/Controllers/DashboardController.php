<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Facades\PostCache;
use App\Models\CampaignDashboardWidget;
use Illuminate\Support\Facades\Auth;

use App\Models\Release;

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
        if (Auth::check() && Auth::user()->can('update', $campaign)) {
            $settings = true;
        }

        $widgets = CampaignDashboardWidget::positioned()->get();
        $release = PostCache::latest();

        return view('home', compact(
            'campaign',
            'settings',
            'release',
            'widgets'
        ));
    }

    /**
     * @param $id
     * @return bool
     */
    public function recent($id)
    {
        $widget = CampaignDashboardWidget::findOrFail($id);
        $campaign = CampaignLocalization::getCampaign();
        if ($widget->widget != CampaignDashboardWidget::WIDGET_RECENT) {
            return response()->json([
                'success' => true
            ]);
        }

        $offset = request()->get('offset', 0);

        $entities = \App\Models\Entity::recentlyModified()
            ->inTags($widget->tags->pluck('id')->toArray())
            ->type($widget->conf('entity'))
            ->acl()
            ->with(['tags', 'updater'])
            ->take(10)
            ->offset($offset)
            ->get();

        return view('dashboard.widgets._recent_list')
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('campaign', $campaign)
            ->with('offset', $offset);
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

        $offset = request()->get('offset', 0);

        $entities = \App\Models\Entity::unmentioned()
            ->inTags($widget->tags->pluck('id')->toArray())
            ->type($widget->conf('entity'))
            ->acl()
            ->with(['updater'])
            ->take(10)
            ->offset($offset)
            ->get();

        return view('dashboard.widgets._recent_list')
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('campaign', $campaign)
            ->with('offset', $offset);
    }
}
