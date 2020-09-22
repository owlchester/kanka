<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Services\ReferralService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        if (Auth::guest()) {
            return $this->front();
        } else {
            return $this->back();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function front()
    {
        return response(view('front.home'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function back()
    {
        $campaignId = Session::get('campaign_id');
        if (empty($campaignId) || !isset($campaignId) || !Auth::user()->hasCampaigns()) {
            return redirect()->route('start');
        }

        // Redirect to real dashboard
        $campaign = CampaignLocalization::getCampaign();
        if ($campaign) {
            return redirect()->route('home');
        }

        // Otherwise, redirect to the last campaign the user has
        $last = Auth::user()->last_campaign_id;
        if (!empty($last)) {
            $campaign = Campaign::find($last);
            if ($campaign) {
                CampaignLocalization::setCampaign($campaign->id);
                return redirect()->to(CampaignLocalization::getUrl($campaign->id));
            }
        }

        abort(500);
    }
}
