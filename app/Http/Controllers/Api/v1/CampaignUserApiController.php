<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Http\Resources\UserResource;

class CampaignUserApiController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return UserResource::collection($campaign->users);
    }
}
