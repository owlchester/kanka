<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCampaignStyle as Request;
use App\Http\Resources\CampaignStyleResource as Resource;
use App\Models\Campaign;
use App\Models\CampaignStyle;

class CampaignStyleApiController extends ApiController
{
    public function __construct()
    {
        $this->middleware('campaign.boosted', ['except' => 'index']);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection(
            $campaign
                ->styles()
                ->paginate()
        );
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, CampaignStyle $campaignStyle)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);

        return new Resource($campaignStyle);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $model = new CampaignStyle($request->all());
        $model->campaign_id = $campaign->id;
        $model->save();
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, CampaignStyle $campaignStyle)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $campaignStyle->update($request->all());

        return new Resource($campaignStyle);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, CampaignStyle $campaignStyle)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $campaignStyle->delete();

        return response()->json(null, 204);
    }
}
