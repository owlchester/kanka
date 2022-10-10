<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampaignHeader;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;

class DashboardHeaderController extends Controller
{
    /**
     * @param Campaign $campaign
     * @param CampaignDashboardWidget|null $campaignDashboardWidget
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, ?CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        $ajax = request()->ajax();

        if (!empty($campaignDashboardWidget) && !empty($campaignDashboardWidget->campaign_id)) {
            if ($campaignDashboardWidget->campaign_id != $campaign->id) {
                abort(404);
            }
        } else {
            $campaignDashboardWidget = null;
        }

        return view('campaigns.forms.dashboard-header.edit')
            ->with('model', $campaign)
            ->with('ajax', $ajax)
            ->with('widget', $campaignDashboardWidget);
    }

    /**
     * @param UpdateCampaignHeader $request
     * @param Campaign $campaign
     * @param CampaignDashboardWidget|null $campaignDashboardWidget
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCampaignHeader $request, Campaign $campaign, ?CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);

        $campaign->update($request->only('excerpt'));

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? ['dashboard' => $campaignDashboardWidget->dashboard_id] : null)
            ->with('success', __('campaigns/dashboard-header.edit.success'));
    }
}
