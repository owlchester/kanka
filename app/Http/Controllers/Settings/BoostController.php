<?php

namespace App\Http\Controllers\Settings;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignBoost;
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
        }

        $boosts = Auth::user()->boosts()->with('campaign')->get();

        return view('settings.boost', compact(
            'campaign',
            'boosts'
        ));
    }


}
