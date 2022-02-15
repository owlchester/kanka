<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->guest()) {
            return $this->front();
        }
        return $this->back();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function front()
    {
        return view('front.home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    protected function back()
    {
        $campaignId = session()->get('campaign_id');
        if (empty($campaignId) || !isset($campaignId) || !auth()->user()->hasCampaigns()) {
            return redirect()->route('start');
        }

        // Redirect to real dashboard
        $campaign = CampaignLocalization::getCampaign();
        if ($campaign) {
            return redirect()->route('home');
        }

        // Otherwise, redirect to the last campaign the user has
        $last = auth()->user()->last_campaign_id;
        if (!empty($last)) {
            $campaign = Campaign::find($last);
            if ($campaign) {
                CampaignLocalization::setCampaign($campaign->id);
                return redirect()->to(CampaignLocalization::getUrl($campaign->id));
            }
        }
        // No valid last campaign? Let's redirect to the last campaign the user had
        $campaigns = auth()->user()->campaigns;
        foreach ($campaigns as $campaign) {
            CampaignLocalization::setCampaign($campaign->id);
            return redirect()->to(CampaignLocalization::getUrl($campaign->id));
        }

        // No campaign? Ok, go to start.
        return redirect()->route('start');

        abort(500);
    }
}
