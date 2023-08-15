<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\ReferralService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReferralService $referralService)
    {
        $this->middleware('auth', ['only' => ['back']]);
        $referralService->validate(request());
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        return $this->back();
    }

    /**
     */
    protected function back()
    {
        $campaignId = session()->get('campaign_id');
        if (empty($campaignId) || !auth()->user()->hasCampaigns()) {
            return redirect()->route('start');
        }

        // Otherwise, redirect to the last campaign the user has
        /** @var Campaign|null $last */
        $last = auth()->user()->lastCampaign;
        if ($last) {
            return redirect()->route('dashboard', $last);
        }

        // No valid last campaign? Let's redirect to the last campaign the user had
        $campaigns = auth()->user()->campaigns;
        foreach ($campaigns as $campaign) {
            return redirect()->route('dashboard', $campaign);
        }

        // No campaign? Ok, go to start.
        return redirect()->route('start');
    }
}
