<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Services\CampaignFollowService;
use Illuminate\Support\Facades\Auth;

class CampaignFollowController extends Controller
{
    /**
     * @var CampaignFollowService
     */
    protected $service;

    public function __construct(CampaignFollowService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('follow', $campaign);

        return response()->json([
            'following' => $this->service->update($campaign, Auth::user())
        ]);
    }
}
