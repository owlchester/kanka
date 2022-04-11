<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaign as Request;

class CampaignApiController extends ApiController
{
    public function index(\Illuminate\Http\Request $request)
    {
        $campaigns = $request
            ->user()
            ->campaigns()
            ->lastSync(request()->get('lastSync'))
            ->paginate();
        return CampaignResource::collection($campaigns);
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $resource = new CampaignResource($campaign);

        return $resource->withMentions();
    }

    public function store(Request $request)
    {
        $model = Campaign::create($request->all());
        return new CampaignResource($model);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $campaign->update($request->all());

        return new CampaignResource($campaign);
    }

    public function delete(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $campaign->delete();

        return response()->json(null, 204);
    }
}
