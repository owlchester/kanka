<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Http\Requests\StoreCampaignDashboardWidget as Request;
use App\Http\Resources\CampaignDashboardWidgetResource as Resource;

class CampaignDashboardWidgetApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign->widgets()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return Resource
     */
    public function show(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        return new Resource($campaignDashboardWidget);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $data = array_merge(['campaign_id' => $campaign->id], $request->all());
        $model = CampaignDashboardWidget::create($data);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        $campaignDashboardWidget->update($request->all());

        return new Resource($campaignDashboardWidget);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        $campaignDashboardWidget->delete();

        return response()->json(null, 204);
    }
}
