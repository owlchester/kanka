<?php

namespace App\Http\Controllers\Api\v1\Campaign;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\UserResource;
use App\Models\Campaign;
use Illuminate\Http\Request;

class UserApiController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);

        return UserResource::collection($campaign->users);
    }

    /**
     * Add a user to a role
     * @param Request $request
     * @param Campaign $campaign
     * @return void
     */
    public function add(Request $request, Campaign $campaign)
    {
        // ?
    }

    /**
     * Remove a role from a user
     * @param Request $request
     * @param Campaign $campaign
     * @return void
     */
    public function remove(Request $request, Campaign $campaign)
    {
        // ?
    }
}
