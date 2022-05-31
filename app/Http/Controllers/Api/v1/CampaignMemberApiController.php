<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\CampaignUserResource;
use App\Models\Campaign;
use App\Models\CampaignUser;

class CampaignMemberApiController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return CampaignUserResource::collection($campaign->members);
    }

    public function show(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('access', $campaign);

        return new CampaignUserResource($campaignUser);
    }
}
