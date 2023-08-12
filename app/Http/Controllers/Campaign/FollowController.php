<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\CampaignFollowService;

class FollowController extends Controller
{
    protected CampaignFollowService $service;

    public function __construct(CampaignFollowService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function update(Campaign $campaign)
    {
        $this->authorize('follow', $campaign);

        return response()->json([
            'following' => $this->service
                ->campaign($campaign)
                ->user(auth()->user())
                ->update()
        ]);
    }
}
