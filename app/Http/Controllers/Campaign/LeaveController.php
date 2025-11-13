<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\LeaveService;
use App\Services\Users\CampaignService;
use Exception;

class LeaveController extends Controller
{
    public function __construct(
        protected LeaveService $leaveService,
        protected CampaignService $campaignService,
    ) {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        return view('campaigns.leave')->with('campaign', $campaign);
    }

    public function process(Campaign $campaign)
    {
        $this->authorize('leave', $campaign);
        if (request()->ajax()) {
            return response()->json();
        }

        try {
            $this->leaveService
                ->campaign($campaign)
                ->user(auth()->user())
                ->leave();

            $this->campaignService
                ->user(auth()->user())
                ->next();

            return redirect()->route('home')
                ->with('success', __('campaigns.leave.success', ['name' => $campaign->name]));
        } catch (Exception $e) {
            $this->campaignService
                ->user(auth()->user())
                ->next();

            return redirect()->route('overview', $campaign)->withErrors($e->getMessage());
        }
    }
}
