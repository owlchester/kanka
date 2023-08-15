<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\LeaveService;
use App\Services\Users\CampaignService;
use Exception;

class LeaveController extends Controller
{
    protected LeaveService $leaveService;
    protected CampaignService $campaignService;

    public function __construct(LeaveService $leaveService, CampaignService $campaignService)
    {
        $this->middleware('auth');
        $this->leaveService = $leaveService;
        $this->campaignService = $campaignService;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('leave', $campaign);

        try {
            $this->leaveService
                ->campaign($campaign)
                ->user(auth()->user())
                ->leave();

            $this->campaignService
                ->user(auth()->user())
                ->next();
            return redirect()->route('home');
        } catch (Exception $e) {
            $this->campaignService
                ->user(auth()->user())
                ->next();
            return redirect()->route('overview', $campaign)->withErrors($e->getMessage());
        }
    }
}
