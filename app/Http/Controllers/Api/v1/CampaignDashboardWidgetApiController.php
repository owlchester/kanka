<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCampaignDashboardWidget as Request;
use App\Http\Resources\CampaignDashboardWidgetResource as Resource;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;

class CampaignDashboardWidgetApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection(
            $campaign->widgets()
                ->lastSync(request()->get('lastSync'))
                ->paginate()
        );
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);

        return new Resource($campaignDashboardWidget);
    }

    /**
     * @return resource
     *
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
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        $campaignDashboardWidget->update($request->all());

        return new Resource($campaignDashboardWidget);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        $campaignDashboardWidget->delete();

        return response()->json(null, 204);
    }
}
