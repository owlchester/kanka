<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\CampaignUserRoleResource as Resource;
use App\Models\Campaign;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CampaignRoleApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->roles()
            ->paginate());
    }
}
