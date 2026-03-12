<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampaignHeader;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardHeaderController extends Controller
{
    /**
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
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
     * @return RedirectResponse
     *
     * @throws AuthorizationException
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
