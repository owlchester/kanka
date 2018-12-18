<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreUserDashboardSetting;
use App\Models\CampaignDashboardWidget;
use Illuminate\Support\Facades\Auth;

use App\Models\Character;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Note;
use App\Models\Organisation;
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

        $release = Release::with(['category'])
            ->where('status', 'PUBLISHED')
            ->orderBy('created_at', 'DESC')
            ->first();


        $widgets = CampaignDashboardWidget::positioned()->get();

        return view('home', compact(
            'campaign',
            'notes',
            'settings',
            'release',
            'widgets'
        ));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('dashboard.settings.setting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Family $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserDashboardSetting $request)
    {
        $setting = Auth::user()->dashboardSetting;
        $setting->update($request->all());
        return redirect()->route('home')->with('success', trans('dashboard.settings.edit.success'));
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

        $entities = \App\Models\Entity::recentlyModified()->type($widget->conf('entity'))->acl()->take(10)->offset($offset)->get();

        return view('dashboard.widgets._recent_list')
            ->with('entities', $entities)
            ->with('widget', $widget)
            ->with('offset', $offset);
    }
}
