<?php

namespace App\Http\Controllers\Settings;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Services\CampaignBoostService;
use App\User;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        // If a campaign was provided, make sure we have access to it
        $campaignId = request()->get('campaign');
        $campaign = null;
        $superboost = false;

        /** @var User $user */
        $user = auth()->user();
        $boosts = $user->boosts()->with('campaign')->groupBy('campaign_id')->get();
        $userCampaigns = $user->campaigns()->unboosted()->whereNotIn('campaigns.id', $boosts->pluck('campaign_id'))->get();

        if (!empty($campaignId)) {
            /** @var Campaign $campaign */
            $campaign = Campaign::where(['id' => (int)$campaignId])->firstOrFail();
            CampaignCache::campaign($campaign);
            $this->authorize('access', $campaign);

            if ($campaign->superboosted()) {
                return redirect()
                    ->route('settings.boost');
            }

            $userCampaigns = $userCampaigns->where('id', '!=', $campaignId);
            $superboost = request()->get('superboost') === '1';
        }

        return view('settings.boosters.index')
            ->with('campaigns', $userCampaigns)
            ->with('boosts', $boosts)
            ->with('focus', $campaign)
            ->with('superboost', $superboost)
        ;
    }
}
