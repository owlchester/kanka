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

        $recentCount = 5;
        $user = null;
        $settings = null;
        if (Auth::check() && Auth::user()->can('update', $campaign)) {
            $settings = true;
        }

        //$characters = Character::

        $release = PostCache::latest();
        $widgets = CampaignDashboardWidget::positioned()->get();

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
        if ($widget->widget != CampaignDashboardWidget::WIDGET_RECENT) {
            return response()->json([
                'success' => true
            ]);
        }

        $offset = request()->get('offset', 0);

        $entities = \App\Models\Entity::recentlyModified()
            ->type($widget->conf('entity'))
            ->acl()
            ->take(10)
            ->offset($offset)
            ->get();

        return view('dashboard.widgets._recent_list')
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('offset', $offset);
    }
}
