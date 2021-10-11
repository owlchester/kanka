<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\CampaignStyle;
use App\Http\Requests\StoreCampaignStyle as Request;
use App\Http\Resources\CampaignStyleResource as Resource;

class CampaignStyleApiController extends ApiController
{
    public function __construct()
    {
        $this->middleware('campaign.boosted', ['except' => 'index']);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->styles()
            ->paginate()
        );
    }

    /**
     * @param Campaign $campaign
     * @param CampaignStyle $campaignStyle
     * @return Resource
     */
    public function show(Campaign $campaign, CampaignStyle $campaignStyle)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        return new Resource($campaignStyle);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $model = new CampaignStyle($request->all());
        $model->campaign_id = $campaign->id;
        $model->save();

        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param CampaignStyle $campaignStyle
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, CampaignStyle $campaignStyle)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $campaignStyle->update($request->all());

        return new Resource($campaignStyle);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param CampaignStyle $campaignStyle
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, CampaignStyle $campaignStyle)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $campaignStyle->delete();

        return response()->json(null, 204);
    }
}
