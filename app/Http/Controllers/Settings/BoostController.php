<?php

namespace App\Http\Controllers\Settings;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\CampaignBoostService;
use Illuminate\Support\Facades\Auth;

class BoostController extends Controller
{
    /**
     * @var CampaignBoostService
     */
    protected $campaignBoostService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CampaignBoostService $campaignBoostService)
    {
        $this->middleware(['auth', 'identity']);
        $this->campaignBoostService = $campaignBoostService;
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // If a campaign was provided, make sure we have access to it
        $campaignId = request()->get('campaign');
        $campaign = null;


        $boosts = Auth::user()->boosts()->with('campaign')->groupBy('campaign_id')->get();
        $userCampaigns = UserCache::campaigns()->where('boost_count', 0)->whereNotIn('id', $boosts->pluck('campaign_id'));

        if (!empty($campaignId)) {
            /** @var Campaign $campaign */
            $campaign = Campaign::where(['id' => (int) $campaignId])->firstOrFail();
            CampaignCache::campaign($campaign);
            $this->authorize('access', $campaign);

            if ($campaign->boosted()) {
                return redirect()
                    ->route('settings.boost')
                    ->with('error', __('campaigns.boost.exceptions.already_boosted', ['campaign' => $campaign->name]));
            }

            $userCampaigns = $userCampaigns->where('id', '!=', $campaignId);
        }

        return view('settings.boost', compact(
            'campaign',
            'userCampaigns',
            'boosts'
        ));
    }
}
