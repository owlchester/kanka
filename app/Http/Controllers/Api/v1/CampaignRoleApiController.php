<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CampaignRole;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Http\Resources\CampaignUserRoleResource as Resource;

class CampaignRoleApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @param Calendar $calendar
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->roles()
            ->paginate());
    }
}