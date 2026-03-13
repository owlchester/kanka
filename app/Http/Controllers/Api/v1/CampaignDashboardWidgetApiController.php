<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\Widget;
use App\Http\Requests\StoreCampaignDashboardWidget as Request;
use App\Http\Resources\CampaignDashboardWidgetResource as Resource;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CampaignDashboardWidgetApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        if ($request->input('widget') === Widget::Gallery->value && ! $campaign->boosted()) {
            abort(403);
        }

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
        if ($campaignDashboardWidget->widget === Widget::Gallery && ! $campaign->boosted()) {
            abort(403);
        }
        $campaignDashboardWidget->update($request->all());

        return new Resource($campaignDashboardWidget);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('update', $campaign);
        $campaignDashboardWidget->delete();

        return response()->json(null, 204);
    }
}
