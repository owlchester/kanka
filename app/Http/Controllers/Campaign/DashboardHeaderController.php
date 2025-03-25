<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampaignHeader;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;

class DashboardHeaderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, ?CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);

        if (! empty($campaignDashboardWidget) && ! empty($campaignDashboardWidget->campaign_id)) {
            if ($campaignDashboardWidget->campaign_id != $campaign->id) {
                abort(404);
            }
        } else {
            $campaignDashboardWidget = null;
        }

        return view('campaigns.forms.dashboard-header.edit')
            ->with('campaign', $campaign)
            ->with('widget', $campaignDashboardWidget);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCampaignHeader $request, Campaign $campaign, ?CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);

        $campaign->update($request->only('excerpt'));

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? [$campaign, 'dashboard' => $campaignDashboardWidget->dashboard_id] : [$campaign])
            ->with('success', __('campaigns/dashboard-header.edit.success'));
    }
}
