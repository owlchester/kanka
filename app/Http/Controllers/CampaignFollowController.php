<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\CampaignFollowService;

class CampaignFollowController extends Controller
{
    protected CampaignFollowService $service;

    public function __construct(CampaignFollowService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Campaign $campaign)
    {
        $this->authorize('follow', $campaign);

        return response()->json([
            'following' => $this->service->update($campaign, auth()->user())
        ]);
    }
}
