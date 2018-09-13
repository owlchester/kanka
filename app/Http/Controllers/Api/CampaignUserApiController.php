<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Http\Resources\User as Resource;
use App\Http\Resources\UserCollection as Collection;

class CampaignUserApiController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return new Collection($campaign->users);
    }
}
