<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\CampaignUserResource;
use App\Models\Campaign;

class CampaignMemberApiController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return CampaignUserResource::collection($campaign->members);
    }
}
